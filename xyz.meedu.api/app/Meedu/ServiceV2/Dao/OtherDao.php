<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

use Carbon\Carbon;
use App\Meedu\ServiceV2\Models\AppConfig;
use App\Meedu\ServiceV2\Models\MediaVideo;
use App\Meedu\ServiceV2\Models\SearchRecord;
use App\Meedu\ServiceV2\Models\UserUploadImage;

class OtherDao implements OtherDaoInterface
{
    public function storeUserUploadImage(int $userId, string $group, string $disk, string $path, string $name, string $visitUrl, string $logApi, string $logIp, string $logUA): void
    {
        UserUploadImage::create([
            'user_id' => $userId,
            'group' => $group,
            'disk' => $disk,
            'path' => $path,
            'name' => $name,
            'visit_url' => $visitUrl,
            'log_api' => $logApi,
            'log_ip' => $logIp,
            'log_ua' => $logUA,
            'created_at' => Carbon::now()->toDateTimeLocalString(),
        ]);
    }

    public function appConfigValueKey(): array
    {
        return AppConfig::query()->get()->pluck('value', 'key')->toArray();
    }

    public function updateValueByKey(string $key, string $value): void
    {
        AppConfig::query()->where('key', $key)->update(['value' => $value]);
    }

    public function getChunksByKeys(array $array): array
    {
        return AppConfig::query()->whereIn('key', $array)->select(['key', 'value'])->pluck('value', 'key')->toArray();
    }

    public function findMediaVideoByVideoId(string $service, string $videoId): array
    {
        $mediaVideo = MediaVideo::query()->where('storage_file_id', $videoId)->where('storage_driver', $service)->first();
        return $mediaVideo ? $mediaVideo->toArray() : [];
    }

    public function storeMediaVideo(array $data): void
    {
        MediaVideo::create($data);
    }

    public function updateMediaVideo(int $id, array $updateData): void
    {
        MediaVideo::query()->where('id', $id)->update($updateData);
    }

    public function deleteMediaVideos(string $service, array $videoIds): void
    {
        MediaVideo::query()->whereIn('storage_file_id', $videoIds)->where('storage_driver', $service)->limit(count($videoIds))->delete();
    }

    public function all(): array
    {
        return AppConfig::query()->orderBy('sort')->get()->toArray();

    }


    public function existSearchRecord(string $resourceType, int $resourceId): bool
    {
        return SearchRecord::query()->where('resource_type', $resourceType)->where('resource_id', $resourceId)->exists();
    }

    public function storeSearchRecord(string $resourceType, int $resourceId, array $data): void
    {
        SearchRecord::query()->create(array_merge($data, [
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
        ]));
    }

    public function updateSearchRecord(string $resourceType, int $resourceId, array $data): void
    {
        $record = SearchRecord::query()->where('resource_type', $resourceType)->where('resource_id', $resourceId)->first();
        if ($record) {
            // 必须通过模型编辑的方式才能触发搜索内容更新
            $record->fill($data)->save();
        }
    }

    public function deleteSearchRecord(string $resourceType, int $resourceId): void
    {
        $record = SearchRecord::query()->where('resource_type', $resourceType)->where('resource_id', $resourceId)->first();
        if ($record) {
            // 必须通过模型删除的方式才能触发搜索内容更新
            $record->delete();
        }
    }

    public function deleteMultiSearchRecord(string $resourceType, array $resourceIds = []): void
    {
        SearchRecord::query()
            ->where('resource_type', $resourceType)
            ->when(!empty($resourceIds), function ($query) use ($resourceIds) {
                return $query->whereIn('resource_id', $resourceIds);
            })
            ->chunk(100, function ($records) {
                foreach ($records as $record) {
                    $record->delete();
                }
            });
    }

    public function deleteAllSearchRecord(): void
    {
        SearchRecord::query()->delete();
    }

    public function takeSearchRecord(string $keywords, int $limit): array
    {
        return SearchRecord::search($keywords)->take($limit)->get()->toArray();
    }

    public function storeMultiSearchRecord(array $insectData): void
    {
        SearchRecord::query()->insert($insectData);
    }

}
