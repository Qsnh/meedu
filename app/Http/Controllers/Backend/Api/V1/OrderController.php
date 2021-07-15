<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Events\PaymentSuccessEvent;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use App\Services\Order\Models\OrderGoods;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $status = $request->input('status', null);
        $userId = $request->input('user_id');
        $orderId = $request->input('order_id');
        $createdAt = $request->input('created_at');
        $goodsId = $request->input('goods_id');
        $goodsName = trim($request->input('goods_name', ''));

        // 排序字段
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');

        $orderIds = [];
        if ($goodsId) {
            $orderIds = OrderGoods::query()->where('goods_id', $goodsId)->select(['oid'])->get()->pluck('oid')->toArray();
        }
        if ($goodsName) {
            $orderIds = array_merge(
                $orderIds,
                OrderGoods::query()->where('goods_name', $goodsName)->select(['oid'])->get()->pluck('oid')->toArray()
            );
        }
        $orderIds && $orderIds = array_flip(array_flip($orderIds));

        $query = Order::query()
            ->with([
                'goods:oid,goods_id,goods_type,goods_name,goods_thumb,goods_charge,goods_ori_charge',
                'paidRecords',
            ])
            ->when($orderIds, function ($query) use ($orderIds) {
                $query->whereIn('id', $orderIds);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($orderId, function ($query) use ($orderId) {
                $query->where('order_id', $orderId);
            })
            ->when($createdAt && is_array($createdAt), function ($query) use ($createdAt) {
                $query->whereBetween('created_at', $createdAt);
            });

        $orders = (clone $query)
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 10));

        // 读取当前读取出来订单的用户
        $userIds = array_column($orders->items(), 'user_id');
        $users = User::query()
            ->select(['id', 'nick_name', 'avatar', 'mobile'])
            ->whereIn('id', $userIds)
            ->get()
            ->keyBy('id');

        // 各状态订单数量统计
        $countMap = [
            Order::STATUS_UNPAY => (clone $query)->where('status', Order::STATUS_UNPAY)->count(),
            Order::STATUS_CANCELED => (clone $query)->where('status', Order::STATUS_CANCELED)->count(),
            Order::STATUS_PAID => (clone $query)->where('status', Order::STATUS_PAID)->count(),
            Order::STATUS_PAYING => (clone $query)->where('status', Order::STATUS_PAYING)->count(),
        ];

        return $this->successData(compact('orders', 'users', 'countMap'));
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
