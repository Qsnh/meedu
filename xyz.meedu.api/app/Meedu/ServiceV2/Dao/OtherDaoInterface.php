<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

interface OtherDaoInterface
{
    public function storeUserUploadImage(
        int    $userId,
        string $group,
        string $disk,
        string $path,
        string $name,
        string $visitUrl,
        string $logApi,
        string $logIp,
        string $logUA
    ): void;

    public function appConfigValueKey(): array;

    public function updateValueByKey(string $key, string $value): void;

    public function getChunksByKeys(array $array): array;

    public function findMediaVideoByVideoId(string $service, string $videoId): array;

    public function storeMediaVideo(array $data): void;

    public function updateMediaVideo(int $id, array $updateData): void;

    public function deleteMediaVideos(string $service, array $videoIds): void;

    public function all(): array;

    public function existSearchRecord(string $resourceType, int $resourceId): bool;

    public function storeSearchRecord(string $resourceType, int $resourceId, array $data): void;

    public function updateSearchRecord(string $resourceType, int $resourceId, array $data): void;

    public function deleteSearchRecord(string $resourceType, int $resourceId): void;

    public function deleteMultiSearchRecord(string $resourceType, array $resourceIds = []): void;

    public function deleteAllSearchRecord(): void;

    public function takeSearchRecord(string $keywords, int $limit): array;

    public function storeMultiSearchRecord(array $insectData): void;
}
