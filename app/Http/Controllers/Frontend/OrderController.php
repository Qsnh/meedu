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
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    public function show($orderId)
    {
        $order = Order::whereOrderId($orderId)->firstOrFail();
        if ($order->status == Order::STATUS_CANCELED) {
            flash('该订单已取消');

            return back();
        }
        if ($order->status == Order::STATUS_PAID) {
            flash('该订单已支付', 'success');

            return back();
        }
        $payments = collect(config('meedu.payment'))->keyBy('sign')->reject(function ($payment) {
            return $payment['pc'] === false;
        });

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
        // 获取PC端能支付的网关
        $payments = collect(config('meedu.payment'))->keyBy('sign')->reject(function ($payment) {
            return $payment['pc'] === false;
        });
        $payment = $request->post('payment');
        if (! isset($payments[$payment])) {
            flash('支付网关不存在');

            return back();
        }

        $order = Order::whereOrderId($orderId)->firstOrFail();
        if (in_array($order->status, [Order::STATUS_PAID, Order::STATUS_CANCELED])) {
            flash('该订单已支付或已取消');

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
}
