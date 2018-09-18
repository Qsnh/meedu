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

use App\Models\RechargePayment;
use Illuminate\Support\Facades\DB;
use App\Events\PaymentSuccessEvent;
use App\Notifications\MemberRechargeNotification;

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

        DB::beginTransaction();
        try {
            // 修改订单状态
            $payment->status = RechargePayment::STATUS_PAYED;
            $payment->save();

            // 增加用户余额
            $payment->user->credit1 += $payment->money;
            $payment->user->save();

            // 消息通知
            $payment->user->notify(new MemberRechargeNotification($payment));

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);
        }
    }
}
