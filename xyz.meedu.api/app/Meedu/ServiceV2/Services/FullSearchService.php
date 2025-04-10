<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use Illuminate\Support\Facades\Artisan;
use App\Meedu\ServiceV2\Dao\OtherDaoInterface;

class FullSearchService implements FullSearchServiceInterface
{

    protected $dao;

    protected $configService;

    public function __construct(OtherDaoInterface $dao, ConfigServiceInterface $configService)
    {
        $this->dao = $dao;
        $this->configService = $configService;
    }

    public function storeOrUpdate(string $resourceType, int $resourceId, string $title, string $thumb, int $charge, string $shortDesc, string $desc): void
    {
        if (!$this->configService->enabledFullSearch()) {
            return;
        }

        $data = [
            'title' => $title,
            'thumb' => $thumb,
            'charge' => $charge,
            'short_desc' => $shortDesc,
            'desc' => $desc,
        ];

        if ($this->dao->existSearchRecord($resourceType, $resourceId)) {
            $this->dao->updateSearchRecord($resourceType, $resourceId, $data);
        } else {
            $this->dao->storeSearchRecord($resourceType, $resourceId, $data);
        }
    }

    public function delete(string $resourceType, int $resourceId): void
    {
        if (!$this->configService->enabledFullSearch()) {
            return;
        }
        $this->dao->deleteSearchRecord($resourceType, $resourceId);
    }

    public function multiDelete(string $resourceType, array $resourceIds = []): void
    {
        if (!$this->configService->enabledFullSearch()) {
            return;
        }
        $this->dao->deleteMultiSearchRecord($resourceType, $resourceIds);
    }

    public function clear(): void
    {
        $this->dao->deleteAllSearchRecord();
        Artisan::call('scout:flush', ['model' => 'App\Meedu\ServiceV2\Models\SearchRecord']);
    }

    public function search(string $keywords, int $page = 1, int $size = 10, string $type = ''): array
    {
        if (!$this->configService->enabledFullSearch()) {
            return [
                'total' => 0,
                'data' => [],
            ];
        }

        $data = $this->dao->takeSearchRecord($keywords, $type ? 300 : 100);
        if ($type) {//如果存在type过滤[meilisearch-v0.21.0暂不支持增加type的过滤,这里需要先读取出数据然后手动过滤]
            $data = collect($data)->filter(function ($item) use ($type) {
                return $item['resource_type'] === $type;
            })->toArray();
        }

        $total = count($data);
        $chunks = array_chunk($data, $size);

        return [
            'total' => $total,
            'data' => $chunks[$page - 1] ?? [],
        ];
    }

    public function storeMulti(array $insectData): void
    {
        if (!$this->configService->enabledFullSearch()) {
            return;
        }
        $this->dao->storeMultiSearchRecord($insectData);
    }

    public function scoutImport(): void
    {
        Artisan::call('scout:import', ['model' => 'App\Meedu\ServiceV2\Models\SearchRecord']);
    }


}
