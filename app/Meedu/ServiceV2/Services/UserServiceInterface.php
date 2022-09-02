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

    public function storeUserDelete(int $userId): void;

    public function cancelUserDelete(int $userId): void;

    public function notifySimpleMessage(int $userId, string $message): void;

    public function userDeleteBatchHandle(): void;

    public function destroyUser(int $userId): void;

    public function findUserById(int $userId): array;

    public function findUserByMobile(string $mobile): array;

    public function storeUserLoginRecord(int $userId, string $token, string $platform, string $ua, string $ip): void;

    public function findLastLoginJTI(int $userId): string;

    public function jtiLogout(int $userId, string $jti): void;

    public function socialiteBind(int $userId, string $app, string $appId, array $data, string $unionId = ''): void;
}
