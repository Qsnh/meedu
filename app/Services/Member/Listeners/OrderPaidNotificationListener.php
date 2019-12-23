<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Listeners;

use App\Events\PaymentSuccessEvent;
use App\Services\Member\Services\NotificationService;

class OrderPaidNotificationListener
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
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
