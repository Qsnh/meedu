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

    public function updateValueByKey(string $key, string $value):void;

    public function getChunksByKeys(array $array):array;

    public function findMediaVideoByVideoId(string $service, string $videoId):array;

    public function storeMediaVideo(array $data):void;

    public function updateMediaVideo(int $id, array $updateData):void;

    public function deleteMediaVideos(string $service, array $videoIds):void;
}
