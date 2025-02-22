<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\VodCourseCreatedEvent;

use Carbon\Carbon;
use App\Constant\BusConstant;
use App\Events\VodCourseCreatedEvent;
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
     * @param VodCourseCreatedEvent $event
     * @return void
     */
    public function handle(VodCourseCreatedEvent $event)
    {
        $course = $this->courseService->find($event->id);
        if (!$course) {
            return;
        }

        if (Carbon::parse($course['published_at'])->isPast() && 1 === $course['is_show']) {
            $this->fullSearchService->storeOrUpdate(
                BusConstant::FULL_SEARCH_RESOURCE_TYPE_VOD_COURSE,
                $event->id,
                $course['title'],
                $course['thumb'],
                $course['charge'],
                $course['short_description'],
                strip_tags($course['original_desc'])
            );
        }
    }
}
