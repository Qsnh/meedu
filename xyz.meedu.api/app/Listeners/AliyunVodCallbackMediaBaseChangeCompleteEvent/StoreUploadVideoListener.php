<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AliyunVodCallbackMediaBaseChangeCompleteEvent;

use App\Events\AliyunVodCallbackMediaBaseChangeCompleteEvent;

class StoreUploadVideoListener
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
     * @param  \App\Events\AliyunVodCallbackMediaBaseChangeCompleteEvent  $event
     * @return void
     */
    public function handle(AliyunVodCallbackMediaBaseChangeCompleteEvent $event)
    {
        //
    }
}
