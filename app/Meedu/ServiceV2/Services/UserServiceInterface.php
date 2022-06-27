<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

interface UserServiceInterface
{
    public function getUserCoursePaginateWithProgress(int $userId, int $page, int $size): array;

    public function getUserLearnedCoursePaginateWithProgress(int $userId, int $page, int $size): array;

    public function getUserLikeCoursePaginateWithProgress(int $userId, int $page, int $size): array;
}
