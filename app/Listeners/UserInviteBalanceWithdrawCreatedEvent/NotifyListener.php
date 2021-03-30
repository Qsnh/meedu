<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Listeners\UserInviteBalanceWithdrawCreatedEvent;

use App\Events\UserInviteBalanceWithdrawCreatedEvent;

class NotifyListener
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
     * @param  UserInviteBalanceWithdrawCreatedEvent  $event
     * @return void
     */
    public function handle(UserInviteBalanceWithdrawCreatedEvent $event)
    {
        //
    }
}
