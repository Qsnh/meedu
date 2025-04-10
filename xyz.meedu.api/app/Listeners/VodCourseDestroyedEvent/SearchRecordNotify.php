<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\VodCourseDestroyedEvent;

use App\Constant\BusConstant;
use App\Events\VodCourseDestroyedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\ServiceV2\Services\FullSearchServiceInterface;

class SearchRecordNotify implements ShouldQueue
{
    use InteractsWithQueue;

    private $fullSearchService;

    public function __construct(FullSearchServiceInterface $fullSearchService)
    {
        $this->fullSearchService = $fullSearchService;
    }

    /**
     * Handle the event.
     *
     * @param VodCourseDestroyedEvent $event
     * @return void
     */
    public function handle(VodCourseDestroyedEvent $event)
    {
        $this->fullSearchService->delete(BusConstant::FULL_SEARCH_RESOURCE_TYPE_VOD_COURSE, $event->id);
    }
}
