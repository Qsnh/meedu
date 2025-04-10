<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\PublishedCoursesSearchIndexBuildEvent;

use App\Constant\BusConstant;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PublishedCoursesSearchIndexBuildEvent;
use App\Meedu\ServiceV2\Services\CourseServiceInterface;
use App\Meedu\ServiceV2\Services\FullSearchServiceInterface;

class VodCourseVideoListener implements ShouldQueue
{
    use InteractsWithQueue;

    private $fullSearchService;
    private $courseService;

    public function __construct(
        FullSearchServiceInterface $fullSearchService,
        CourseServiceInterface     $courseService
    ) {
        $this->fullSearchService = $fullSearchService;
        $this->courseService = $courseService;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\PublishedCoursesSearchIndexBuildEvent $event
     * @return void
     */
    public function handle(PublishedCoursesSearchIndexBuildEvent $event)
    {
        $fields = ['id', 'title'];
        $videos = $this->courseService->getPublishedUnIndexedVideos($fields);

        if (empty($videos)) {
            return;
        }

        foreach ($videos as $video) {
            try {
                $this->fullSearchService->storeOrUpdate(
                    BusConstant::FULL_SEARCH_RESOURCE_TYPE_VOD_COURSE_VIDEO,
                    $video['id'],
                    $video['title'],
                    '',
                    0,
                    '',
                    ''
                );
            } catch (\Exception $e) {
                Log::error(sprintf('Video[%s] sync failed: %s', $video['title'], $e->getMessage()));
            }
        }
    }
}
