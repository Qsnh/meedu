<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AliyunVodCallbackTranscodeCompleteEvent;

use App\Events\AliyunVodCallbackTranscodeCompleteEvent;

class UpdateMediaVideoListener
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
     * @param  \App\Events\AliyunVodCallbackTranscodeCompleteEvent  $event
     * @return void
     */
    public function handle(AliyunVodCallbackTranscodeCompleteEvent $event)
    {
        //
    }
}
