<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AliyunVodCallbackFileUploadCompleteEvent;

use App\Constant\FrontendConstant;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\ServiceV2\Services\OtherServiceInterface;
use App\Events\AliyunVodCallbackFileUploadCompleteEvent;

class VideoVisibilityToggleListener implements ShouldQueue
{
    use InteractsWithQueue;

    private $otherService;

    public function __construct(OtherServiceInterface $otherService)
    {
        $this->otherService = $otherService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AliyunVodCallbackFileUploadCompleteEvent  $event
     * @return void
     */
    public function handle(AliyunVodCallbackFileUploadCompleteEvent $event)
    {
        $this->otherService->mediaVideoVisibilityToggle(FrontendConstant::VOD_SERVICE_ALIYUN, $event->videoId);
    }
}
