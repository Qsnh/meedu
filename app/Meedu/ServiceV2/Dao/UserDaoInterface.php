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

    public function findUserDeleteJobUnHandle(int $userId): array;

    public function findUserOrFail(int $userId, array $fields): array;

    public function storeUserDeleteJob(int $userId, string $mobile): int;

    public function deleteUserDeleteJobUnHandle(int $userId): int;

    public function notifySimpleMessage(int $userId, string $message);

    public function getUserDeleteJobUnHandle(int $limit): array;

    public function deleteUserRelateData(int $userId): void;

    public function destroyUser(int $userId):int;

    public function changeUserDeleteJobsHandled(array $ids): int;
}
