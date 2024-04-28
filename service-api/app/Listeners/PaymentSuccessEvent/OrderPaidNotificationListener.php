<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\PaymentSuccessEvent;

use App\Events\PaymentSuccessEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Member\Services\NotificationService;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class OrderPaidNotificationListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @param $event PaymentSuccessEvent
     */
    public function handle($event)
    {
        $order = $event->order;
        $this->notificationService->notifyOrderPaidMessage($order['user_id'], $order['order_id']);
    }
}
