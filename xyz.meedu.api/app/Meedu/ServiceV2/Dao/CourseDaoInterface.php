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

    public function findOrFail(int $id): array;

    public function videoPaginate(int $page, int $size, array $fields, array $orderBy, array $params, array $with, array $withCount): array;

    public function paginate(int $page, int $size, array $fields, array $orderBy, array $params, array $with, array $withCount): array;

    public function find(int $id): array;

    public function findVideo(int $id): array;

    public function getVideosByCourseId(int $id, array $fields): array;

    public function getPublishedUnIndexedCourses(array $fields): array;

    public function getPublishedUnIndexedVideos(array $fields): array;
}
