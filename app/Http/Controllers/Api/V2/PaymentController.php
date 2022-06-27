<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Constant\FrontendConstant;
use App\Exceptions\SystemException;
use App\Meedu\Payment\Wechat\WechatMini;
use App\Meedu\Payment\Wechat\WechatScan;
use App\Services\Base\Services\CacheService;
use App\Meedu\Payment\Contract\PaymentStatus;
use App\Services\Base\Services\ConfigService;
use App\Services\Order\Services\OrderService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class PaymentController extends BaseController
{

    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @var CacheService
     */
    protected $cacheService;

    public function __construct(OrderServiceInterface $orderService, CacheServiceInterface $cacheService)
    {
        $this->orderService = $orderService;
        $this->cacheService = $cacheService;
    }

    /**
     * @api {post} /api/v2/order/payment/wechat/mini 微信小程序支付
     * @apiGroup 订单
     * @apiName PaymentWechatMini
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {String} openid openid
     * @apiParam {String} order_id 订单编号
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.appId appId
     * @apiSuccess {String} data.nonceStr nonceStr
     * @apiSuccess {String} data.package package
     * @apiSuccess {String} data.paySign paySign
     * @apiSuccess {String} data.signType signType
     * @apiSuccess {String} data.timeStamp timeStamp
     */
    public function wechatMiniPay(Request $request)
    {
        $openid = $request->input('openid');
        $orderId = $request->input('order_id');
        if (!$openid || !$orderId) {
            return $this->error(__('参数错误'));
        }

        $order = $this->orderService->findUser($this->id(), $orderId);
        if ($order['status'] !== FrontendConstant::ORDER_UN_PAY) {
            return $this->error(__('订单状态错误'));
        }

        $updateData = [
            'payment' => FrontendConstant::PAYMENT_SCENE_WECHAT,
            'payment_method' => FrontendConstant::PAYMENT_SCENE_WECHAT_MINI,
        ];
        $this->orderService->change2Paying($order['id'], $updateData);
        $order = array_merge($order, $updateData);

        // 创建远程订单
        $paymentHandler = app()->make(WechatMini::class);

        /**
         * @var PaymentStatus $createResult
         */
        $createResult = $paymentHandler->create($order, ['openid' => $openid]);
        if ($createResult->status === false) {
            throw new SystemException(__('系统错误'));
        }

        $data = $createResult->data;

        return $this->data($data);
    }

    /**
     * @api {get} /api/v2/order/payments 支付网关列表
     * @apiGroup 订单
     * @apiName Payments
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {String} scene 支付场景[h5,wechat]
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.sign 网关值
     * @apiSuccess {String} data.name 网关名
     */
    public function payments(Request $request)
    {
        $scene = $request->input('scene');
        if (!$scene) {
            return $this->error(__('参数错误'));
        }

        $payments = get_payments($scene)->map(function ($val) {
            return [
                'sign' => $val['sign'],
                'name' => $val['name'],
                'icon' => url($val['logo']),
            ];
        })->toArray();
        sort($payments);
        return $this->data($payments);
    }

    /**
     * @api {get} /api/v2/order/pay/redirect 跳转到第三方支付
     * @apiGroup 订单
     * @apiName PayRedirect
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {String=h5:手机浏览器,wechat:微信浏览器} payment_scene 支付场景
     * @apiParam {String=alipay:支付宝支付,wechat-jsapi:微信jsapi支付,handPay:手动打款} payment 支付方式
     * @apiParam {String} order_id 订单编号
     * @apiParam {String} redirect 支付完成回跳地址
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function payRedirect(Request $request)
    {
        $payment = $request->input('payment');
        $paymentScene = $request->input('payment_scene');
        $orderId = $request->input('order_id');

        if (!$payment || !$paymentScene || !$orderId) {
            return $this->error(__('参数错误'));
        }

        $payments = get_payments($paymentScene);
        if (!$payments) {
            return $this->error(__('错误'));
        }
        if (!isset($payments[$payment])) {
            return $this->error(__('错误'));
        }

        $order = $this->orderService->findUser($this->id(), $orderId);
        if ($order['status'] !== FrontendConstant::ORDER_UN_PAY) {
            return $this->error(__('订单状态错误'));
        }

        $updateData = [
            'payment' => $payment,
            'payment_method' => $payments[$payment][$paymentScene],
        ];
        $this->orderService->change2Paying($order['id'], $updateData);
        $order = array_merge($order, $updateData);

        // 创建远程订单
        $paymentHandler = app()->make($payments[$payment]['handler']);
        $createResult = $paymentHandler->create($order);
        if ($createResult->status === false) {
            throw new SystemException(__('系统错误'));
        }

        return $createResult->data;
    }

    /**
     * @api {get} /api/v2/order/pay/handPay 手动打款支付
     * @apiGroup 订单
     * @apiName PaymentHandPayV2
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.text 手动打款支付信息
     */
    public function handPay()
    {
        /**
         * @var ConfigService $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        $text = $configService->getHandPayIntroducation();

        return $this->data(['text' => $text]);
    }

    /**
     * @api {post} /api/v2/order/pay/wechatScan 微信扫码支付[PC]
     * @apiGroup 订单
     * @apiName PaymentWechatScan
     * @apiVersion v2.0.0
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {String} order_id 订单编号
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.code_url 微信支付二维码的文本值，用该值生成二维码
     */
    public function wechatScan(Request $request)
    {
        $orderId = $request->input('order_id');
        if (!$orderId) {
            return $this->error(__('参数错误'));
        }

        $order = $this->orderService->findUser($this->id(), $orderId);
        if ($order['status'] !== FrontendConstant::ORDER_UN_PAY) {
            return $this->error(__('订单状态错误'));
        }

        $updateData = [
            'payment' => FrontendConstant::PAYMENT_SCENE_WECHAT,
            'payment_method' => FrontendConstant::PAYMENT_SCENE_WECHAT_SCAN,
        ];
        $this->orderService->change2Paying($order['id'], $updateData);
        $order = array_merge($order, $updateData);

        // 创建远程订单
        $paymentHandler = app()->make(WechatScan::class);

        /**
         * @var PaymentStatus $createResult
         */
        $createResult = $paymentHandler->create($order);
        if ($createResult->status === false) {
            throw new SystemException(__('系统错误'));
        }

        $data = $createResult->data;

        return $this->data([
            'code_url' => $data['code_url'],
        ]);
    }
}
