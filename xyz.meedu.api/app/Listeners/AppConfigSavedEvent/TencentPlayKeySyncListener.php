<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AppConfigSavedEvent;

use App\Events\AppConfigSavedEvent;

class TencentPlayKeySyncListener
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
     * @param  \App\Events\AppConfigSavedEvent  $event
     * @return void
     */
    public function handle(AppConfigSavedEvent $event)
    {
        //
    }
}
