<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AliyunVodCallbackFileUploadCompleteEvent;

use App\Events\AliyunVodCallbackFileUploadCompleteEvent;

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
     * @param  \App\Events\AliyunVodCallbackFileUploadCompleteEvent  $event
     * @return void
     */
    public function handle(AliyunVodCallbackFileUploadCompleteEvent $event)
    {
        //
    }
}
