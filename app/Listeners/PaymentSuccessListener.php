<?php

namespace App\Listeners;

use App\Events\PaymentSuccessEvent;
use App\Models\RechargePayment;
use App\Notifications\MemberRechargeNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class PaymentSuccessListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentSuccessEvent  $event
     * @return void
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
