<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

interface UserDaoInterface
{
    public function getUserCoursePaginate(int $userId, int $page, int $size): array;

    public function getUserCourses(int $userId, array $courseIds): array;

    public function getUserCourseWatchRecordsChunk(int $userId, array $courseIds): array;

    public function getPerUserLearnedCourseVideoCount(int $userId, array $courseIds): array;

    public function getUserLearnedCoursePaginate(int $userId, int $page, int $size): array;

    public function getUserLikeCoursePaginate(int $userId, int $page, int $size): array;

    public function getPerUserLearnedCourseLastVideo(int $userId, array $courseIds): array;
}
