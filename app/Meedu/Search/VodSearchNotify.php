<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Search;

use App\Services\Other\Proxies\SearchRecordService;
use App\Services\Other\Interfaces\SearchRecordServiceInterface;

class VodSearchNotify implements SearchNotifyContract
{
    public const RESOURCE_TYPE = 'vod';

    public function create(int $resourceId, array $data)
    {
        /**
         * @var SearchRecordService $searchRecordService
         */
        $searchRecordService = app()->make(SearchRecordServiceInterface::class);

        if ($searchRecordService->exists(self::RESOURCE_TYPE, $resourceId)) {
            $searchRecordService->update(self::RESOURCE_TYPE, $resourceId, $data);
            return;
        }

        $searchRecordService->store(self::RESOURCE_TYPE, $resourceId, $data);
    }

    public function update(int $resourceId, array $data)
    {
        /**
         * @var SearchRecordService $searchRecordService
         */
        $searchRecordService = app()->make(SearchRecordServiceInterface::class);

        if (!$searchRecordService->exists(self::RESOURCE_TYPE, $resourceId)) {
            $searchRecordService->store(self::RESOURCE_TYPE, $resourceId, $data);
            return;
        }

        $searchRecordService->update(self::RESOURCE_TYPE, $resourceId, $data);
    }

    public function delete(int $resourceId)
    {
        /**
         * @var SearchRecordService $searchRecordService
         */
        $searchRecordService = app()->make(SearchRecordServiceInterface::class);
        $searchRecordService->destroy(self::RESOURCE_TYPE, $resourceId);
    }

    public function deleteBatch(array $ids)
    {
        /**
         * @var SearchRecordService $searchRecordService
         */
        $searchRecordService = app()->make(SearchRecordServiceInterface::class);

        foreach ($ids as $id) {
            $searchRecordService->destroy(self::RESOURCE_TYPE, $id);
        }
    }
}
