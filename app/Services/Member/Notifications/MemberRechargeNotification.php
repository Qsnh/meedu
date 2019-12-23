<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\RechargePayment;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MemberRechargeNotification extends Notification
{
    use Queueable;

    public $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct(RechargePayment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('充值到账提醒')
            ->view('emails.member_recharge', ['payment' => $this->payment]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'money' => $this->payment->money,
        ];
    }
}
