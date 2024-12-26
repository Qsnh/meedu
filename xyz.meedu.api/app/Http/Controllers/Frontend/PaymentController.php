<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Frontend;

use App\Bus\UniPayBus;
use Yansongda\Pay\Pay;
use Illuminate\Http\Request;
use App\Constant\BusConstant;
use App\Meedu\Cache\MemoryCache;
use App\Events\PaymentSuccessEvent;
use Illuminate\Support\Facades\Log;
use App\Meedu\ServiceV2\Services\OrderServiceInterface;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class PaymentController extends FrontendController
{

    public function index(Request $request, ConfigServiceInterface $configService, OrderServiceInterface $orderService, UniPayBus $bus)
    {
        $sUrl = $request->input('s_url') ?? '';
        if ($sUrl) {
            $sUrl = urldecode($sUrl);
        }
        $fUrl = $request->input('f_url') ?? '';
        if ($fUrl) {
            $fUrl = urldecode($fUrl);
        }

        // 交易签名 => 缓存key => 背后存着订单的信息
        $sign = $request->input('sign');
        if (!$sign) {
            return view('payment.error', ['msg' => __('参数错误')]);
        }

        $orderId = $bus->getOrderBySign($sign);
        if (!$orderId) {
            return view('payment.error', ['msg' => __('参数错误')]);
        }

        $order = $orderService->findById($orderId);
        if (BusConstant::ORDER_STATUS_SUCCESS === $order['status']) {
            return view('payment.success', compact('sUrl'));
        }
        if (BusConstant::ORDER_STATUS_CANCEL === $order['status']) {
            return view('payment.error', ['msg' => __('订单已取消')]);
        }

        // 订单商品信息
        $orderGoodsList = $orderService->getOrderGoodsListById($order['id']);
        if (!$orderGoodsList) {
            return view('payment.error', ['msg' => __('订单信息有误')]);
        }

        // 计算实际需要支付的金额
        ['total' => $total, 'promoCodePaidRecord' => $promoCodePaidRecord] = $bus->calculateActualPaymentAmount($order);
        if ($total < 0) {
            return view('payment.error', ['msg' => __('订单无需支付')]);
        }

        // 支付渠道开关
        $enabledWechatPayment = $configService->enabledWechatPayment();
        $enabledAlipayPayment = $configService->enabledAlipayPayment();
        $enabledHandPayment = $configService->enabledHandPayPayment();

        if ($request->isMethod('POST') || $order['payment']) {
            // 默认读取订单表的已记录的payment
            $payment = $order['payment'];

            if (!$payment && $request->isMethod('POST')) {
                $payment = $request->input('payment_method');
                if (!$payment) {
                    return view('payment.error', ['msg' => __('参数错误')]);
                }
                if (!in_array($payment, ['wechat', 'alipay'])) {
                    return view('payment.error', ['msg' => __('参数错误')]);
                }
            }

            if ('wechat' === $payment && !$enabledWechatPayment) {
                return view('payment.error', ['msg' => __('未开启微信支付')]);
            } elseif ('alipay' === $payment && !$enabledAlipayPayment) {
                return view('payment.error', ['msg' => __('未开启支付宝支付')]);
            }

            // 可选值 H5 | 空 => 用于区分微信JSAPI支付或者微信H5支付
            $platform = $request->post('platform');

            // 更新订单的支付方式
            if (!$order['payment']) {
                $order['payment'] = $payment;
                $order['payment_method'] = 'wechat' === $payment ? ($platform ? 'wap' : 'wechat-jsapi') : 'wap';
                $orderService->changePaymentAndMethod($order['id'], $order['payment'], $order['payment_method']);
            }

            if ('wechat' === $payment) {
                if ($platform || 'wap' === $order['payment_method']) {
                    // 微信H5支付
                    $redirectContent = $bus->createWechatH5OrderWithCache(
                        $order['order_id'],
                        (string)$total * 100,
                        $order['order_id']
                    );
                    return response($redirectContent);
                }

                // 微信JSAPI支付
                // 微信JSAPI支付前需要获取openid
                $openid = $bus->getWechatOpenid();
                if (!$openid) {
                    $callbackUrl = url_append_query(
                        route('payment.index'),
                        [
                            'sign' => $sign,
                            's_url' => urlencode($sUrl),
                            'f_url' => urlencode($fUrl),
                        ]
                    );
                    return $bus->redirectWechatOAuth($callbackUrl);
                }
                // 创建微信JSAPI支付订单
                $data = $bus->createWechatJSAPIOrderWithCache(
                    $order['order_id'],
                    (string)$total * 100,
                    $order['order_id'],
                    $openid
                );
                return view('payment.wechat-jsapi', compact('data', 'order', 'sUrl', 'fUrl'));
            } elseif ('alipay' === $payment) {
                $returnSuccessUrl = route('payment.success');
                if ($sUrl) {
                    $returnSuccessUrl = url_append_query($returnSuccessUrl, ['s_url' => urlencode($sUrl)]);
                }
                $redirectContent = $bus->createAlipayH5OrderWithCache(
                    $order['order_id'],
                    (string)$total,
                    $order['order_id'],
                    $returnSuccessUrl
                );
                return response($redirectContent);
            }
        }

        // 手动打款的相关描述
        $handPayInfo = $configService->handPayInfo();

        return view('payment.index', compact(
            'order',
            'orderGoodsList',
            'enabledAlipayPayment',
            'enabledWechatPayment',
            'enabledHandPayment',
            'total',
            'promoCodePaidRecord',
            'handPayInfo',
            'sUrl',
            'fUrl'
        ));
    }

    public function successPage(Request $request)
    {
        $sUrl = $request->input('s_url') ?? '';
        if ($sUrl) {
            $sUrl = urldecode($sUrl);
        }

        return view('payment.success', compact('sUrl'));
    }

    public function callback(ConfigServiceInterface $configService, OrderServiceInterface $orderService, $payment)
    {
        if (BusConstant::PAYMENT_ALIPAY === $payment) {
            $pay = Pay::alipay($configService->getAlipayConfig());
            $data = $pay->verify();

            $notifyType = $data['notify_type'];
            $tradeStatus = $data['trade_status'];

            Log::info(__METHOD__ . '|支付宝支付回调数据|' . $notifyType . '|' . $tradeStatus, [$data]);

            if (!('trade_status_sync' === $notifyType && 'TRADE_SUCCESS' === $tradeStatus)) {
                Log::info('非支付成功回调');
                return '非支付成功回调';
            }

            $order = $orderService->findByOrderNo($data['out_trade_no']);
            if ($order) {
                // 支付订单加入内存缓存中
                MemoryCache::getInstance()->set($data['out_trade_no'], $order, true);
                // event
                event(new PaymentSuccessEvent($order));
            }

            return $pay->success();
        } elseif (BusConstant::PAYMENT_WECHAT === $payment) {
            $pay = Pay::wechat($configService->getWechatPayConfig());
            $data = $pay->verify();

            Log::info(__METHOD__ . '|微信支付回调数据', compact('data'));

            // 查找订单
            $order = $orderService->findByOrderNo($data['out_trade_no']);
            if ($order) {
                // 支付订单加入内存缓存中
                MemoryCache::getInstance()->set($data['out_trade_no'], $order, true);
                // event
                event(new PaymentSuccessEvent($order));
            }

            return $pay->success();
        }

        abort(404);
    }
}
