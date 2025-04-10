<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\FullSearchDataRebuildEvent;

use Carbon\Carbon;
use App\Constant\BusConstant;
use App\Events\FullSearchDataRebuildEvent;
use App\Meedu\ServiceV2\Services\CourseServiceInterface;
use App\Meedu\ServiceV2\Services\FullSearchServiceInterface;

class VodVideoRebuildListener
{
    private $fullSearchService;
    private $courseService;

    public function __construct(FullSearchServiceInterface $fullSearchService, CourseServiceInterface $courseService)
    {
        $this->fullSearchService = $fullSearchService;
        $this->courseService = $courseService;
    }

    public function handle(FullSearchDataRebuildEvent $event)
    {
        $page = 1;
        $size = 100;
        while (1) {
            ['data' => $data] = $this->courseService->videoPaginate(
                $page,
                $size,
                ['id', 'title'],
                ['id', 'desc'],
                [
                    'is_show' => 1,
                    'lte_published_at' => Carbon::now()->toDateTimeLocalString(),
                ],
                [],
                []
            );
            if (!$data) {
                break;
            }

            // 插入
            $insectData = [];
            $now = Carbon::now()->toDateTimeLocalString();
            foreach ($data as $tmpItem) {
                $insectData[] = [
                    'resource_type' => BusConstant::FULL_SEARCH_RESOURCE_TYPE_VOD_COURSE_VIDEO,
                    'resource_id' => $tmpItem['id'],
                    'title' => $tmpItem['title'],
                    'thumb' => '',
                    'charge' => 0,
                    'short_desc' => '',
                    'desc' => '',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            $this->fullSearchService->storeMulti($insectData);

            if (count($data) < $size) {
                break;
            }

            $page++;
        }

        $this->fullSearchService->scoutImport();
    }
}
