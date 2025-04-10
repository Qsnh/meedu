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

class VodRebuildListener
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
            ['data' => $data] = $this->courseService->paginate(
                $page,
                $size,
                ['id', 'title', 'thumb', 'charge', 'short_description', 'original_desc'],
                ['id', 'desc'],
                [
                    'lte_published_at' => Carbon::now()->toDateTimeLocalString(),
                    'is_show' => 1,
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
                    'resource_type' => BusConstant::FULL_SEARCH_RESOURCE_TYPE_VOD_COURSE,
                    'resource_id' => $tmpItem['id'],
                    'title' => $tmpItem['title'],
                    'thumb' => $tmpItem['thumb'],
                    'charge' => $tmpItem['charge'],
                    'short_desc' => $tmpItem['short_description'],
                    'desc' => strip_tags($tmpItem['original_desc']),
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
