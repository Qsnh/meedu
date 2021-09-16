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

    public function search(string $keywords, int $size = 10, string $type = '')
    {
        if (!$type) {
            return SearchRecord::search($keywords)->paginate($size);
        }

        $results = SearchRecord::search($keywords)->get();
        $ids = $results->pluck('resource_id')->toArray();

        return SearchRecord::query()
            ->whereIn('resource_id', $ids)
            ->where('resource_type', $type)
            ->paginate($size);
    }
}
