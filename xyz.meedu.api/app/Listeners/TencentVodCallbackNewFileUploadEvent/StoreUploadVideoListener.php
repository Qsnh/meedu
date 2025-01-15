<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\TencentVodCallbackNewFileUploadEvent;

use App\Constant\FrontendConstant;
use App\Bus\MediaVideoCategoryBindBus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\TencentVodCallbackNewFileUploadEvent;
use App\Meedu\ServiceV2\Services\OtherServiceInterface;

class StoreUploadVideoListener implements ShouldQueue
{
    use InteractsWithQueue;

    private $otherService;
    private $bus;

    public function __construct(OtherServiceInterface $otherService, MediaVideoCategoryBindBus $bus)
    {
        $this->otherService = $otherService;
        $this->bus = $bus;
    }

    public function handle(TencentVodCallbackNewFileUploadEvent $event)
    {
        $data = $event->data;
        $categoryId = $this->bus->pull($event->videoId);
        $categoryId && $data['category_id'] = $this->bus->pull($event->videoId);
        $this->otherService->storeOrUpdateMediaVideo(FrontendConstant::VOD_SERVICE_TENCENT, $event->videoId, $data);
    }
}
