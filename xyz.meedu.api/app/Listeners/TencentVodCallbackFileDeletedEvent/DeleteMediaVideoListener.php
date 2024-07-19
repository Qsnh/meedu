<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\TencentVodCallbackFileDeletedEvent;

use App\Constant\FrontendConstant;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\TencentVodCallbackFileDeletedEvent;
use App\Meedu\ServiceV2\Services\OtherServiceInterface;

class DeleteMediaVideoListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $otherService;

    public function __construct(OtherServiceInterface $otherService)
    {
        $this->otherService = $otherService;
    }

    public function handle(TencentVodCallbackFileDeletedEvent $event)
    {
        $this->otherService->deleteMediaVideos(FrontendConstant::VOD_SERVICE_TENCENT, $event->videoIds);
    }
}
