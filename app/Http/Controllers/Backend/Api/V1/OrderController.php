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
        $status = $request->input('status', null);
        $userId = $request->input('user_id');
        $orderId = $request->input('order_id');

        $orders = Order::query()
            ->with(['goods', 'paidRecords'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($orderId, function ($query) use ($orderId) {
                $query->where('order_id', $orderId);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        // 读取当前读取出来订单的用户
        $userIds = array_column($orders->items(), 'user_id');
        $users = User::query()
            ->select(['id', 'nick_name', 'avatar', 'mobile'])
            ->whereIn('id', $userIds)
            ->get()
            ->keyBy('id');

        return $this->successData(compact('orders', 'users'));
    }

    public function detail($id)
    {
        $order = Order::query()
            ->with(['goods', 'paidRecords'])
            ->where('id', $id)
            ->firstOrFail();

        $user = User::query()->select(['id', 'nick_name', 'avatar', 'mobile'])->where('id', $order['user_id'])->first();

        return $this->successData([
            'order' => $order,
            'user' => $user,
        ]);
    }

    public function finishOrder($id)
    {
        $order = Order::findOrFail($id);
        event(new PaymentSuccessEvent($order->toArray()));
        return $this->success();
    }
}
