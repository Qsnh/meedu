<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners;

use Exception;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Events\PaymentSuccessEvent;
use App\Notifications\SimpleMessageNotification;

class PaymentSuccessListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param PaymentSuccessEvent $event
     */
    public function handle(PaymentSuccessEvent $event)
    {
        $payment = $event->payment;
        if (! $payment) {
            return;
        }
        $order = $payment->order;

        DB::beginTransaction();
        try {
            // 修改订单状态
            $order->status = Order::STATUS_PAID;
            $order->save();

            // 商品归属
            $order->user->handlerOrderSuccess($order);

            // 消息通知
            $order->user->notify(new SimpleMessageNotification($order->getNotificationContent()));

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);
        }
    }
}
