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
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function show($orderId)
    {
        $order = Order::whereOrderId($orderId)->firstOrFail();

        return view('order.show', compact('order'));
    }
}
