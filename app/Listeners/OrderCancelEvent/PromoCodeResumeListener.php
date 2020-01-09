<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\OrderCancelEvent;

use App\Events\OrderCancelEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;

class PromoCodeResumeListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var OrderService
     */
    protected $orderService;
    /**
     * @var PromoCodeService
     */
    protected $promoCodeService;

    /**
     * PromoCodeResumeListener constructor.
     * @param OrderServiceInterface $orderService
     * @param PromoCodeServiceInterface $promoCodeService
     */
    public function __construct(OrderServiceInterface $orderService, PromoCodeServiceInterface $promoCodeService)
    {
        $this->orderService = $orderService;
        $this->promoCodeService = $promoCodeService;
    }

    /**
     * Handle the event.
     *
     * @param OrderCancelEvent $event
     * @return void
     */
    public function handle(OrderCancelEvent $event)
    {
        $order = $this->orderService->findId($event->orderId);
        // 恢复promo_code[使用次数]
        $promoCodeOrderPaidRecords = $this->promoCodeService->getOrderPaidRecords($order['id']);
        if ($promoCodeOrderPaidRecords) {
            $promoCodeIds = array_column($promoCodeOrderPaidRecords, 'paid_type_id');
            $this->promoCodeService->decrementUsedTimes($promoCodeIds);
        }
        // 删除记录
        $this->orderService->destroyOrderPaidRecords($order['id']);
    }
}
