<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Order\Services;

use Carbon\Carbon;
use App\Events\OrderCancelEvent;
use App\Businesses\BusinessState;
use Illuminate\Support\Facades\DB;
use App\Events\PaymentSuccessEvent;
use App\Exceptions\ServiceException;
use App\Services\Order\Models\Order;
use App\Services\Order\Models\PromoCode;
use App\Services\Order\Models\OrderGoods;
use App\Services\Order\Models\OrderRefund;
use App\Services\Order\Models\OrderPaidRecord;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;

class OrderService implements OrderServiceInterface
{
    protected $configService;
    protected $businessState;

    public function __construct(ConfigServiceInterface $configService, BusinessState $businessState)
    {
        $this->configService = $configService;
        $this->businessState = $businessState;
    }

    /**
     * @param int $userId
     * @param int $total
     * @param array $goodsItems
     * @param int $promoCodeId
     * @return mixed
     */
    public function createOrder(int $userId, int $total, array $goodsItems, int $promoCodeId)
    {
        return DB::transaction(function () use ($userId, $total, $goodsItems, $promoCodeId) {
            // 优惠码抵扣
            $promoCodeDiscount = 0;
            $promoCode = PromoCode::query()->where('id', $promoCodeId)->first();
            if ($promoCode && $this->businessState->promoCodeCanUse($userId, $promoCode->toArray())) {
                $promoCodeDiscount = $promoCode['invited_user_reward'];
                // 记录使用次数
                $promoCode->increment('used_times', 1);
            }

            // 订单状态
            $orderStatus = Order::STATUS_UNPAY;
            if ($total - $promoCodeDiscount <= 0) {
                $orderStatus = Order::STATUS_PAID;
            }

            $order = Order::create([
                'user_id' => $userId,
                'charge' => $total,
                'status' => $orderStatus,
                'order_id' => $this->genOrderNo($userId),
            ]);

            $orderGoodsItems = [];
            foreach ($goodsItems as $goodsItem) {
                $orderGoodsItems[] = [
                    'user_id' => $userId,
                    'oid' => $order['id'],
                    'num' => 1,
                    'charge' => $goodsItem['charge'],
                    'goods_id' => $goodsItem['id'],
                    'goods_type' => $goodsItem['type'],
                    'goods_name' => $goodsItem['goods_name'] ?? '',
                    'goods_thumb' => $goodsItem['goods_thumb'] ?? '',
                    'goods_charge' => (int)($goodsItem['goods_charge'] ?? ''),
                    'goods_ori_charge' => (int)($goodsItem['goods_ori_charge'] ?? ''),

                    // todo 即将废弃
                    'order_id' => '',
                ];
            }
            OrderGoods::insert($orderGoodsItems);

            // 优惠码抵扣记录
            if ($promoCodeDiscount > 0) {
                OrderPaidRecord::create([
                    'user_id' => $userId,
                    'order_id' => $order['id'],
                    'paid_total' => $promoCodeDiscount,
                    'paid_type' => OrderPaidRecord::PAID_TYPE_PROMO_CODE,
                    'paid_type_id' => $promoCode['id']
                ]);
            }

            // 订单支付事件
            if ($order['status'] === Order::STATUS_PAID) {
                event(new PaymentSuccessEvent($order->toArray()));
            }

            return $order->toArray();
        });
    }

    /**
     * @param int $userId
     * @param array $course
     * @param int $promoCodeId
     * @return array
     */
    public function createCourseOrder(int $userId, array $course, int $promoCodeId): array
    {
        return $this->createOrder($userId, $course['charge'], [
            [
                'id' => $course['id'],
                'charge' => $course['charge'],
                'type' => OrderGoods::GOODS_TYPE_COURSE,
                'goods_name' => $course['title'] ?? '',
                'goods_thumb' => $course['thumb'] ?? '',
                'goods_charge' => $course['charge'] ?? 0,
                'goods_ori_charge' => $course['charge'] ?? 0,
            ]
        ], $promoCodeId);
    }

    /**
     * @param int $userId
     * @param array $role
     * @param int $promoCodeId
     * @return array
     */
    public function createRoleOrder(int $userId, array $role, int $promoCodeId): array
    {
        return $this->createOrder($userId, $role['charge'], [
            [
                'id' => $role['id'],
                'charge' => $role['charge'],
                'type' => OrderGoods::GOODS_TYPE_ROLE,
                'goods_name' => $role['name'] ?? '',
                'goods_thumb' => '',
                'goods_charge' => $role['charge'] ?? 0,
                'goods_ori_charge' => $role['charge'] ?? 0,
            ]
        ], $promoCodeId);
    }

    /**
     * @param int $userId
     * @return string
     * @throws \Exception
     */
    protected function genOrderNo(int $userId): string
    {
        $time = date('His');
        $rand = random_int(10, 99);

        return $userId . $time . $rand;
    }

    public function findOrFail(string $orderId): array
    {
        return Order::query()->where('order_id', $orderId)->firstOrFail()->toArray();
    }

    public function findUser(int $userId, string $orderId): array
    {
        return Order::query()
            ->where('user_id', $userId)
            ->where('order_id', $orderId)
            ->firstOrFail()
            ->toArray();
    }

    public function findId(int $id): array
    {
        return Order::query()->where('id', $id)->firstOrFail()->toArray();
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @throws ServiceException
     */
    public function change2Paying(int $id, array $data): void
    {
        $order = Order::findOrFail($id);
        if ($order->status != Order::STATUS_UNPAY) {
            throw new ServiceException('order status error');
        }
        $data['status'] = Order::STATUS_PAYING;
        $order->update($data);
    }

    /**
     * @param int $id
     *
     * @throws ServiceException
     */
    public function cancel(int $id): void
    {
        $order = Order::findOrFail($id);
        if (!in_array($order->status, [Order::STATUS_PAYING, Order::STATUS_UNPAY])) {
            throw new ServiceException('order status error');
        }
        $order->update(['status' => Order::STATUS_CANCELED]);

        event(new OrderCancelEvent($order['id']));
    }

    public function userOrdersPaginate(int $userId, int $page, int $pageSize): array
    {
        $query = Order::query()->where('user_id', $userId)->where('status', Order::STATUS_PAID);
        $total = $query->count();
        $list = $query
            ->with(['goods:id,oid,goods_id,goods_type,goods_name,goods_thumb,goods_charge,goods_ori_charge,num,charge'])
            ->latest()
            ->forPage($page, $pageSize)
            ->get()
            ->toArray();

        return compact('total', 'list');
    }

    /**
     * 订单改为已完成
     *
     * @param int $id
     */
    public function changePaid(int $id): void
    {
        Order::query()->where('id', $id)->firstOrFail()->update(['status' => Order::STATUS_PAID]);
    }

    /**
     * 获取订单的商品
     *
     * @param int $id
     * @return array
     */
    public function getOrderProducts(int $id): array
    {
        return OrderGoods::query()->where('oid', $id)->get()->toArray();
    }

    /**
     * 获取超时订单
     *
     * @param string $date
     * @return array
     */
    public function getTimeoutOrders(string $date): array
    {
        return Order::query()
            ->whereIn('status', [Order::STATUS_UNPAY, Order::STATUS_PAYING])
            ->where('created_at', '<=', $date)
            ->get()
            ->toArray();
    }

    /**
     * @param int $id
     * @return int
     */
    public function getOrderPaidRecordsTotal(int $id): int
    {
        return intval(OrderPaidRecord::whereOrderId($id)->sum('paid_total'));
    }

    /**
     * @param int $id
     * @param int $userId
     * @param int $paidTotal
     */
    public function createOrderPaidRecordDefault(int $id, int $userId, int $paidTotal): void
    {
        OrderPaidRecord::create([
            'user_id' => $userId,
            'order_id' => $id,
            'paid_total' => $paidTotal,
            'paid_type' => OrderPaidRecord::PAID_TYPE_DEFAULT,
        ]);
    }

    /**
     * 删除订单支付记录
     *
     * @param int $id
     */
    public function destroyOrderPaidRecords(int $id): void
    {
        OrderPaidRecord::query()->where('order_id', $id)->delete();
    }

    /**
     * 计算订单直接支付的金额
     *
     * @param int $orderId
     * @return int
     */
    public function getDirectPaidTotal(int $orderId): int
    {
        return (int)OrderPaidRecord::query()
            ->where('order_id', $orderId)
            ->where('paid_type', OrderPaidRecord::PAID_TYPE_DEFAULT)
            ->sum('paid_total');
    }

    /**
     * @param string $refundNo
     * @return array
     */
    public function findOrderRefund(string $refundNo): array
    {
        return OrderRefund::query()
            ->where('refund_no', $refundNo)
            ->firstOrFail()
            ->toArray();
    }

    public function changeOrderRefundStatus(int $id, int $status): void
    {
        $updateData = ['status' => $status];
        if ($status === OrderRefund::STATUS_SUCCESS) {
            $updateData['success_at'] = Carbon::now()->toDateTimeLocalString();
        }
        OrderRefund::query()->where('id', $id)->update($updateData);
    }

    /**
     * @param int $limit
     * @return array
     */
    public function takeProcessingRefundOrders(int $limit): array
    {
        return OrderRefund::query()
            ->with(['order:id,order_id'])
            ->where('status', OrderRefund::STATUS_DEFAULT)
            ->orderBy('id')
            ->take($limit)
            ->get()
            ->toArray();
    }
}
