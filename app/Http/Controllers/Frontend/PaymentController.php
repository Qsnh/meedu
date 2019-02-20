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

class PaymentController extends FrontendController
{
    public function callback(Request $request)
    {
        $orderId = $request->input('out_trade_no');
        $order = Order::whereOrderId($orderId)->firstOrFail();
        $payments = config('meedu.payment');
        $handler = $payments[$order->payment]['handler'];

        return app()->make($handler)->callback($order);
    }
}
