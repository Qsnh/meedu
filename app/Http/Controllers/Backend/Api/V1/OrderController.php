<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Events\PaymentSuccessEvent;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $status = $request->input('status', null);
        $orders = Order::with(['user', 'goods'])
            ->status($status)
            ->keywords($keywords)
            ->latest()
            ->paginate($request->input('page_size', 12));

        return $this->successData($orders);
    }

    public function finishOrder($id)
    {
        $order = Order::findOrFail($id);
        event(new PaymentSuccessEvent($order->toArray()));
        return $this->success();
    }
}
