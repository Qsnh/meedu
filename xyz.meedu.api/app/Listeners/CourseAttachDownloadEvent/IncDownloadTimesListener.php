<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\CourseAttachDownloadEvent;

use Carbon\Carbon;
use App\Meedu\Utils\IP;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CourseAttachDownloadEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\ServiceV2\Services\CourseServiceInterface;

class IncDownloadTimesListener implements ShouldQueue
{
    use InteractsWithQueue;

    private $courseService;

    public function __construct(CourseServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\CourseAttachDownloadEvent $event
     * @return void
     */
    public function handle(CourseAttachDownloadEvent $event)
    {
        $extra = $event->extra;
        $extra['ip_area'] = IP::queryCity($extra['ip']);
        $extra['created_at'] = Carbon::now()->toDateTimeLocalString();
        $this->courseService->attachDownload($event->userId, $event->courseId, $event->attachId, $extra);
    }
}
