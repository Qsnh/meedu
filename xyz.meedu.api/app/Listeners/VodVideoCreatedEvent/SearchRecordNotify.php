<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\VodVideoCreatedEvent;

use Carbon\Carbon;
use App\Constant\BusConstant;
use App\Events\VodVideoCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\ServiceV2\Services\CourseServiceInterface;
use App\Meedu\ServiceV2\Services\FullSearchServiceInterface;

class SearchRecordNotify implements ShouldQueue
{
    use InteractsWithQueue;

    private $fullSearchService;
    private $courseService;

    public function __construct(FullSearchServiceInterface $fullSearchService, CourseServiceInterface $courseService)
    {
        $this->fullSearchService = $fullSearchService;
        $this->courseService = $courseService;
    }

    /**
     * Handle the event.
     *
     * @param VodVideoCreatedEvent $event
     * @return void
     */
    public function handle(VodVideoCreatedEvent $event)
    {
        $video = $this->courseService->findVideo($event->id);
        if (!$video) {
            return;
        }

        if (Carbon::parse($video['published_at'])->isPast() && 1 === $video['is_show']) {
            $this->fullSearchService->storeOrUpdate(
                BusConstant::FULL_SEARCH_RESOURCE_TYPE_VOD_COURSE_VIDEO,
                $video['id'],
                $video['title'],
                '',
                0,
                '',
                ''
            );
        }
    }
}
