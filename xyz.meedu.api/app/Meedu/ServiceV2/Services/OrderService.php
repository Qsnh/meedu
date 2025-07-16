<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use App\Constant\BusConstant;
use App\Businesses\BusinessState;
use Illuminate\Support\Facades\DB;
use App\Events\PaymentSuccessEvent;
use App\Meedu\ServiceV2\Dao\OrderDaoInterface;

class OrderService implements OrderServiceInterface
{
    private $orderDao;

    public function __construct(OrderDaoInterface $orderDao)
    {
        $this->orderDao = $orderDao;
    }

    public function findById(int $orderId): array
    {
        return $this->orderDao->findById($orderId);
    }

    public function getOrderGoodsListById($id): array
    {
        return $this->orderDao->getOrderGoodsListById($id);
    }

    public function getOrderPaidRecordsById($id): array
    {
        return $this->orderDao->getOrderPaidRecordsById($id);
    }

    public function changePaymentAndMethod($id, string $payment, string $paymentMethod): int
    {
        return $this->orderDao->updateData(['id' => $id], ['payment' => $payment, 'payment_method' => $paymentMethod]);
    }

    public function createOrder(int $userId, $orderGoodsInfo, $promoCode): array
    {
        return DB::transaction(function () use ($userId, $orderGoodsInfo, $promoCode) {
            $total = $orderGoodsInfo['charge'];

            // 优惠码抵扣
            $promoCodeDiscount = 0;
            $promoCodeItem = $this->orderDao->findPromoCode($promoCode);
            if ($promoCodeItem) {
                /**
                 * @var BusinessState $stateBus
                 */
                $stateBus = app()->make(BusinessState::class);
                if ($stateBus->promoCodeCanUse($userId, $promoCodeItem)) {
                    $promoCodeDiscount = $promoCodeItem['invited_user_reward'];
                    // promoCode使用次数+1
                    $this->orderDao->incrementPromoCodeUsedTimes($promoCodeItem['id']);
                }
            }

            // 订单状态
            $orderStatus = BusConstant::ORDER_STATUS_PAYING;
            if ($total - $promoCodeDiscount <= 0) {
                $orderStatus = BusConstant::ORDER_STATUS_SUCCESS;
            }

            // 创建订单时包含协议版本
            $orderData = [
                'user_id' => $userId,
                'charge' => $total,
                'status' => $orderStatus,
                'order_id' => date('YmdHis') . mt_rand(1000, 9999),
            ];

            // 服务协议
            if (isset($orderGoodsInfo['agreement_id'])) {
                $orderData['agreement_id'] = $orderGoodsInfo['agreement_id'];
            }

            $order = $this->orderDao->store($orderData);

            $this->orderDao->storeOrderGoodsItem([
                'user_id' => $userId,
                'oid' => $order['id'],
                'num' => 1,
                'charge' => $orderGoodsInfo['charge'],
                'goods_id' => $orderGoodsInfo['id'],
                'goods_type' => $orderGoodsInfo['type'],
                'goods_name' => $orderGoodsInfo['name'] ?? '',
                'goods_thumb' => $orderGoodsInfo['thumb'] ?? '',
                'goods_charge' => (int)($goodsItem['charge'] ?? ''),
                'goods_ori_charge' => (int)($goodsItem['ori_charge'] ?? ''),

                // todo - 废弃
                'order_id' => 0,
            ]);

            // 优惠码抵扣记录
            if ($promoCodeDiscount > 0) {
                $this->orderDao->storeOrderPaidRecord([
                    'user_id' => $userId,
                    'order_id' => $order['id'],
                    'paid_total' => $promoCodeDiscount,
                    'paid_type' => BusConstant::ORDER_PAID_TYPE_PROMO_CODE,
                    'paid_type_id' => $promoCodeItem['id']
                ]);
            }

            // 订单支付事件
            if (BusConstant::ORDER_STATUS_SUCCESS === $order['status']) {
                event(new PaymentSuccessEvent($order));
            }

            $order['discount'] = $promoCodeDiscount;
            return $order;
        });
    }

    public function findByOrderNo(string $orderNo): array
    {
        return $this->orderDao->findByOrderNo($orderNo);
    }

}
