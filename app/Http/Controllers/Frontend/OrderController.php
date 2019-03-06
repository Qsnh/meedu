<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Cache;
use App\Meedu\Payment\Eshanghu\Eshanghu;

class OrderController extends Controller
{
    public function show($orderId)
    {
        $order = Auth::user()->orders()->whereOrderId($orderId)->firstOrFail();
        if ($order->status == Order::STATUS_CANCELED) {
            flash('该订单已取消');

            return back();
        }
        if ($order->status == Order::STATUS_PAID) {
            flash('该订单已支付', 'success');

            return back();
        }
        if ($order->status == Order::STATUS_PAYING) {
            $handler = config('meedu.payment.'.$order->payment.'.handler');

            return redirect($handler::payUrl($order));
        }
        $payments = get_payments();

        return v('frontend.order.show', compact('order', 'payments'));
    }

    /**
     * 创建第三方支付订单.
     *
     * @param Request         $request
     * @param OrderRepository $repository
     * @param $orderId
     *
     * @return bool|\Illuminate\Http\RedirectResponse|mixed
     */
    public function pay(Request $request, OrderRepository $repository, $orderId)
    {
        $order = Auth::user()->orders()->whereOrderId($orderId)->firstOrFail();
        if (in_array($order->status, [Order::STATUS_PAID, Order::STATUS_CANCELED])) {
            flash('该订单已支付或已取消');

            return back();
        }

        // 获取PC端能支付的网关
        $payments = get_payments();
        $payment = $order->payment ?: $request->post('payment');
        if (! isset($payments[$payment])) {
            flash('支付网关不存在');

            return back();
        }

        $response = $repository->createRemoteOrder($order, $payment);
        if ($response === false) {
            flash('远程支付订单创建失败');

            return back();
        }

        return $response;
    }

    /**
     * 支付成功返回界面.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success(Request $request)
    {
        $orderId = $request->input('out_trade_no', '');
        $order = Order::whereOrderId($orderId)->firstOrFail();

        return v('frontend.order.success', compact('order'));
    }

    /**
     * 微信扫码支付.
     *
     * @param $orderId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function wechat($orderId)
    {
        $order = Auth::user()->orders()->whereOrderId($orderId)->firstOrFail();
        $wechatData = Cache::get(sprintf(config('cachekey.order.wechat_remote_order.name'), $order->order_id));
        if (! $wechatData) {
            $order->status = Order::STATUS_CANCELED;
            $order->save();

            flash('参数丢失');

            return redirect('/');
        }
        $qrcodeUrl = $wechatData['code_url'];

        return v('frontend.order.wechat', compact('qrcodeUrl', 'order'));
    }

    /**
     * 易商户重新支付.
     *
     * @param $orderId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function eshanghu($orderId)
    {
        $order = Auth::user()->orders()->whereOrderId($orderId)->firstOrFail();
        $codeUrl = Cache::get(sprintf(Eshanghu::CACHE_KEY, $order->order_id));
        if (! $codeUrl) {
            $order->status = Order::STATUS_CANCELED;
            $order->save();

            flash('该订单已过期，请重新下单。');

            return redirect('/');
        }

        return v('frontend.payment.eshanghu', compact('codeUrl', 'order'));
    }
}
