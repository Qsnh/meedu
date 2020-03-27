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

use Illuminate\Http\Request;
use App\Events\PaymentSuccessEvent;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $status = $request->input('status', null);
        $orders = Order::with(['goods', 'paidRecords'])
            ->status($status)
            ->keywords($keywords)
            ->latest()
            ->paginate($request->input('page_size', 10));
        $userIds = array_column($orders->all(), 'user_id');
        $users = User::select(['id', 'nick_name', 'avatar', 'mobile'])->whereIn('id', $userIds)->get()->keyBy('id');

        return $this->successData(compact('orders', 'users'));
    }

    public function finishOrder($id)
    {
        $order = Order::findOrFail($id);
        event(new PaymentSuccessEvent($order->toArray()));
        return $this->success();
    }
}
