<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

interface CourseServiceInterface
{
    public function chunk(array $ids, array $fields, array $params, array $with, array $withCount): array;

    public function videoChunk(array $ids, array $fields, array $params, array $with, array $withCount): array;

    public function getCoursePublishedVideos(int $courseId, array $fields): array;

    public function findAttachByIdAndCourseId(int $attachId, int $courseId): array;

    public function findAttachById(int $id): array;

    public function attachDownload(int $userId, int $courseId, int $attachId, array $data): void;
}
