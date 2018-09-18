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

use App\Events\AdministratorLoginSuccessEvent;

class AdministratorLoginSuccessListener
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
     * @param AdministratorLoginSuccessEvent $event
     */
    public function handle(AdministratorLoginSuccessEvent $event)
    {
        $administrator = $event->administrator;

        $administrator->last_login_ip = request()->getClientIp();
        $administrator->last_login_date = date('Y-m-d H:i:s');
        $administrator->save();
    }
}
