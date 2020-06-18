<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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

    /**
     * @param $event
     * @throws \App\Exceptions\ServiceException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle($event)
    {
        // 修改订单状态
        $this->orderService->changePaid($event->order['id']);
        // 记录PaidRecords
        $paidTotal = $this->businessState->calculateOrderNeedPaidSum($event->order);
        $this->orderService->createOrderPaidRecordDefault($event->order['id'], $event->order['user_id'], $paidTotal);
    }
}
