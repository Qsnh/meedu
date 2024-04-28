<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Search;

use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Other\Interfaces\SearchRecordServiceInterface;

class VodSearchNotify implements SearchNotifyContract
{
    public const RESOURCE_TYPE = 'vod';

    private $searchRecordService;

    public function __construct(SearchRecordServiceInterface $searchRecordService)
    {
        $this->searchRecordService = $searchRecordService;
    }

    public function closed()
    {
        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);
        return $configService->enabledFullSearch() === false;
    }

    public function create(int $resourceId, array $data)
    {
        if ($this->closed()) {
            return;
        }

        if ($this->searchRecordService->exists(self::RESOURCE_TYPE, $resourceId)) {
            $this->searchRecordService->update(self::RESOURCE_TYPE, $resourceId, $data);
            return;
        }

        $this->searchRecordService->store(self::RESOURCE_TYPE, $resourceId, $data);
    }

    public function update(int $resourceId, array $data)
    {
        if ($this->closed()) {
            return;
        }

        if (!$this->searchRecordService->exists(self::RESOURCE_TYPE, $resourceId)) {
            $this->searchRecordService->store(self::RESOURCE_TYPE, $resourceId, $data);
            return;
        }

        $this->searchRecordService->update(self::RESOURCE_TYPE, $resourceId, $data);
    }

    public function delete(int $resourceId)
    {
        if ($this->closed()) {
            return;
        }

        $this->searchRecordService->destroy(self::RESOURCE_TYPE, $resourceId);
    }

    public function deleteBatch(array $ids)
    {
        if ($this->closed()) {
            return;
        }

        foreach ($ids as $id) {
            $this->searchRecordService->destroy(self::RESOURCE_TYPE, $id);
        }
    }
}
