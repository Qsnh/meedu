<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AliyunVodCallbackVideoAnalysisCompleteEvent;

use App\Constant\FrontendConstant;
use App\Bus\MediaVideoCategoryBindBus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\ServiceV2\Services\OtherServiceInterface;
use App\Events\AliyunVodCallbackVideoAnalysisCompleteEvent;

class UpdateMediaVideoListener implements ShouldQueue
{
    use InteractsWithQueue;

    private $otherService;
    private $mediaVideoCategoryBindBus;

    public function __construct(OtherServiceInterface $otherService, MediaVideoCategoryBindBus $mediaVideoCategoryBindBus)
    {
        $this->otherService = $otherService;
        $this->mediaVideoCategoryBindBus = $mediaVideoCategoryBindBus;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\AliyunVodCallbackVideoAnalysisCompleteEvent $event
     * @return void
     */
    public function handle(AliyunVodCallbackVideoAnalysisCompleteEvent $event)
    {
        $data = ['is_hidden' => 0];
        $categoryId = $this->mediaVideoCategoryBindBus->pull($event->videoId);
        $categoryId && $data['category_id'] = $categoryId;

        $this->otherService->storeOrUpdateMediaVideo(
            FrontendConstant::VOD_SERVICE_ALIYUN,
            $event->videoId,
            array_merge($event->extra, $data)
        );
    }
}
