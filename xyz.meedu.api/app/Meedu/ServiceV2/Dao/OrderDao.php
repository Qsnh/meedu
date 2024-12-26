<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

use Illuminate\Support\Arr;
use App\Meedu\ServiceV2\Models\Order;
use App\Meedu\ServiceV2\Models\PromoCode;
use App\Meedu\ServiceV2\Models\OrderGoods;
use App\Meedu\ServiceV2\Models\OrderPaidRecord;

class OrderDao implements OrderDaoInterface
{
    public function findById(int $orderId): array
    {
        $item = Order::query()->where('id', $orderId)->first();
        return $item ? $item->toArray() : [];
    }

    public function getOrderGoodsListById($id): array
    {
        return OrderGoods::query()->where('oid', $id)->get()->toArray();
    }

    public function getOrderPaidRecordsById($id): array
    {
        return OrderPaidRecord::query()->where('order_id', $id)->get()->toArray();
    }

    public function updateData(array $where, array $data): int
    {
        if (Arr::except($where, ['id'])) {
            throw new \Exception(__('仅允许字段 :fields 作为更新条件', [':fields' => implode(', ', ['id'])]));
        }
        if (!Arr::only($where, ['id'])) {
            throw new \Exception(__('至少需要一个更新条件'));
        }

        return Order::query()
            ->when(isset($where['id']), function ($query) use ($where) {
                $query->where('id', $where['id']);
            })
            ->update($data);
    }

    public function findPromoCode($promoCode): array
    {
        $item = PromoCode::query()->where('code', $promoCode)->first();
        return $item ? $item->toArray() : [];
    }

    public function incrementPromoCodeUsedTimes(int $id): int
    {
        return PromoCode::query()->where('id', $id)->increment('used_times');
    }

    public function storeOrderGoodsItem(array $data): void
    {
        OrderGoods::create($data);
    }

    public function storeOrderPaidRecord(array $data): void
    {
        OrderPaidRecord::create($data);
    }

    public function store(array $data): array
    {
        $order = Order::create($data);
        return $order->toArray();
    }

    public function findByOrderNo(string $orderNo): array
    {
        $item = Order::query()->where('order_id', $orderNo)->first();
        return $item ? $item->toArray() : [];
    }

}
