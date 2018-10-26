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
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    public function show(OrderRepository $repository, $orderId)
    {
        $order = Order::whereOrderId($orderId)->firstOrFail();
        $pay = $repository->payInfo($order);

        return view('frontend.order.show', compact('order', 'pay'));
    }
}
