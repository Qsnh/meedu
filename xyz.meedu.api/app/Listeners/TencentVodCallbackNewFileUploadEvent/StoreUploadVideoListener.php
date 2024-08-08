<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\TencentVodCallbackNewFileUploadEvent;

use App\Constant\FrontendConstant;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\TencentVodCallbackNewFileUploadEvent;
use App\Meedu\ServiceV2\Services\OtherServiceInterface;

class StoreUploadVideoListener implements ShouldQueue
{
    use InteractsWithQueue;

    private $otherService;

    public function __construct(OtherServiceInterface $otherService)
    {
        $this->otherService = $otherService;
    }

    public function handle(TencentVodCallbackNewFileUploadEvent $event)
    {
        $this->otherService->storeOrUpdateMediaVideo(FrontendConstant::VOD_SERVICE_TENCENT, $event->videoId, $event->data);
    }
}
