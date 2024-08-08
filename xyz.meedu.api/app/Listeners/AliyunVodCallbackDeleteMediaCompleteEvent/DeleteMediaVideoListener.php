<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AliyunVodCallbackDeleteMediaCompleteEvent;

use App\Constant\FrontendConstant;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\ServiceV2\Services\OtherServiceInterface;
use App\Events\AliyunVodCallbackDeleteMediaCompleteEvent;

class DeleteMediaVideoListener implements ShouldQueue
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
     * @param  \App\Events\AliyunVodCallbackDeleteMediaCompleteEvent  $event
     * @return void
     */
    public function handle(AliyunVodCallbackDeleteMediaCompleteEvent $event)
    {
        $this->otherService->deleteMediaVideo(FrontendConstant::VOD_SERVICE_ALIYUN, $event->videoId);
    }
}
