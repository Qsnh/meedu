<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

interface CommentServiceInterface
{
    public function comments(int $rt, int $rid): array;

    public function replies(int $rt, int $rid, int $parentId): array;

    public function create(array $data): array;

    public function deleteUserDATA(int $userId): void;

    public function deleteResourceComment(string $rt, int $rid): void;
}
