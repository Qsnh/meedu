<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\OrderRefundProcessed;

use App\Bus\RefundBus;
use App\Events\OrderRefundProcessed;
use App\Services\Order\Services\OrderService;
use App\Services\Member\Services\NotificationService;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class UserNotify
{

    /**
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * @var OrderService
     */
    protected $orderService;

    protected $refundBus;

    public function __construct(
        NotificationServiceInterface $notificationService,
        RefundBus $refundBus,
        OrderServiceInterface $orderService
    ) {
        $this->notificationService = $notificationService;
        $this->refundBus = $refundBus;
        $this->orderService = $orderService;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\OrderRefundProcessed $event
     * @return void
     */
    public function handle(OrderRefundProcessed $event)
    {
        if (!$this->refundBus->isSuccess($event->status)) {
            return;
        }
        $order = $this->orderService->findId($event->orderRefund['order_id']);

        $this->notificationService->notify(
            $event->orderRefund['user_id'],
            __('订单:orderNo已成功退款:amount元', [
                'orderNo' => $order['order_id'],
                'amount' => $event->orderRefund['amount'] / 100,
            ])
        );
    }
}
