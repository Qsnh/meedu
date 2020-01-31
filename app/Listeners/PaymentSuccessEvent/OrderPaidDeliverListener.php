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

use App\Events\PaymentSuccessEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Order\Services\OrderService;
use App\Services\Member\Services\DeliverService;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Member\Interfaces\DeliverServiceInterface;

class OrderPaidDeliverListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var OrderService
     */
    protected $orderService;
    /**
     * @var DeliverService
     */
    protected $deliverService;

    public function __construct(
        OrderServiceInterface $orderService,
        DeliverServiceInterface $deliverService
    ) {
        $this->orderService = $orderService;
        $this->deliverService = $deliverService;
    }

    /**
     * @param $event PaymentSuccessEvent
     */
    public function handle($event)
    {
        $order = $event->order;

        // 发货
        $orderProducts = $this->orderService->getOrderProducts($order['id']);
        foreach ($orderProducts as $orderProduct) {
            $method = 'deliver' . ucfirst(strtolower($orderProduct['goods_type']));
            if (!method_exists($this->deliverService, $method)) {
                continue;
            }
            $this->deliverService->$method($order['user_id'], $orderProduct['goods_id'], $orderProduct['charge']);
        }
    }
}
