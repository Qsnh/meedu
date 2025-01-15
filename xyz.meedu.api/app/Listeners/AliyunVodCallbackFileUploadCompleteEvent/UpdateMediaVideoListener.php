<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AliyunVodCallbackFileUploadCompleteEvent;

use App\Constant\FrontendConstant;
use App\Bus\MediaVideoCategoryBindBus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\ServiceV2\Services\OtherServiceInterface;
use App\Events\AliyunVodCallbackFileUploadCompleteEvent;

class UpdateMediaVideoListener implements ShouldQueue
{
    use InteractsWithQueue;

    private $otherService;
    private $mediaVideoCategoryBindBus;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(OtherServiceInterface $otherService, MediaVideoCategoryBindBus $mediaVideoCategoryBindBus)
    {
        $this->otherService = $otherService;
        $this->mediaVideoCategoryBindBus = $mediaVideoCategoryBindBus;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\AliyunVodCallbackFileUploadCompleteEvent $event
     * @return void
     */
    public function handle(AliyunVodCallbackFileUploadCompleteEvent $event)
    {
        $data = ['size' => $event->size];
        $categoryId =  $this->mediaVideoCategoryBindBus->pull($event->videoId);
        $categoryId && $data['category_id'] = $categoryId;

        $this->otherService->storeOrUpdateMediaVideo(
            FrontendConstant::VOD_SERVICE_ALIYUN,
            $event->videoId,
            $data
        );
    }
}
