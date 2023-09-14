<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\OrderRefundProcessed;

use App\Events\OrderRefundProcessed;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Interfaces\OrderServiceInterface;

class OrderRefundStatusChange
{

    /**
     * @var OrderService
     */
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
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
        $this->orderService->changeOrderRefundStatus($event->orderRefund['id'], $event->status);
    }
}
