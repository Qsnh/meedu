<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

interface CourseDaoInterface
{
    public function chunk(array $ids, array $fields, array $params, array $with, array $withCount): array;

    public function videoChunk(array $ids, array $fields, array $params, array $with, array $withCount): array;

    public function getCoursePublishedVideoIds(int $courseId): array;

    public function attachFind(array $array): array;

    public function attachIncDownloadTimes(int $attachId): int;

    public function storeCourseAttachDownloadRecord(int $userId, int $courseId, int $attachId, array $extra): int;
}
