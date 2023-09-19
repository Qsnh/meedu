<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Interfaces;

interface SocialiteServiceInterface
{

    public function findBind(string $app, string $appId): array;

    public function getBindUserId(string $app, string $appId): int;

    public function bindApp(int $userId, string $app, string $appId, array $data, string $unionId = ''): void;

    public function bindAppWithNewUser(string $app, string $appId, array $data, string $unionId = ''): int;

    public function userSocialites(int $userId): array;

    public function cancelBind(string $app, int $userId): void;

    public function findUnionId(string $unionId): array;

    public function updateUnionId(int $id, string $unionId): void;
}
