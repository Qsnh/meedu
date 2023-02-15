<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Proxies;

use App\Services\Other\Models\SearchRecord;
use App\Services\Other\Interfaces\SearchRecordServiceInterface;

class SearchRecordService implements SearchRecordServiceInterface
{
    public function exists(string $resourceType, int $resourceId): bool
    {
        return SearchRecord::query()->where('resource_id', $resourceId)->where('resource_type', $resourceType)->exists();
    }

    public function store(string $resourceType, int $resourceId, array $data): void
    {
        $data = array_merge($data, [
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
        ]);
        SearchRecord::create($data);
    }

    public function destroy(string $resourceType, int $resourceId): void
    {
        $searchRecord = SearchRecord::query()->where('resource_id', $resourceId)->where('resource_type', $resourceType)->first();
        if ($searchRecord) {
            $searchRecord->delete();
        }
    }

    public function update(string $resourceType, int $resourceId, array $data): void
    {
        $searchRecord = SearchRecord::query()->where('resource_id', $resourceId)->where('resource_type', $resourceType)->first();
        if ($searchRecord) {
            $searchRecord->fill($data)->save();
        }
    }

    public function search(string $keywords, int $page = 1, int $size = 10, $type = '')
    {
        $results = SearchRecord::search($keywords)->take($type ? 300 : 100)->get();

        $data = $results->toArray();
        if ($type) {//如果存在type过滤[meilisearch-v0.21.0暂不支持增加type的过滤,这里需要先读取出数据然后手动过滤]
            $data = $results->filter(function ($item) use ($type) {
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
}
