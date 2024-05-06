<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\PaymentSuccessEvent;

use App\Businesses\BusinessState;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Interfaces\OrderServiceInterface;

class OrderPaidStatusChangeListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var OrderService
     */
    protected $orderService;
    protected $businessState;

    public function __construct(OrderServiceInterface $orderService, BusinessState $businessState)
    {
        $this->orderService = $orderService;
        $this->businessState = $businessState;
    }

    public function handle($event)
    {
        // 修改订单状态为已完成
        $this->orderService->changePaid($event->order['id']);

        // 如果订单还有未支付的金额的话
        // 那么将这部分未支付金额直接改为以直接支付的方式支付
        $paidTotal = $this->businessState->calculateOrderNeedPaidSum($event->order);
        if ($paidTotal > 0) {
            $this->orderService->createOrderPaidRecordDefault($event->order['id'], $event->order['user_id'], $paidTotal);
        }
    }
}
