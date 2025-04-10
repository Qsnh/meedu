<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

interface CommentDaoInterface
{
    public function getComments(int $rt, int $rid, int $limit = 10): array;

    public function getAllChildComments(int $rt, int $rid, int $parentId): array;

    public function getCommentsByIds(array $ids): array;

    public function create(array $data): array;

    public function findById(int $id, array $fields, array $params = []): array;

    public function getTotalCount(int $rt, int $rid): int;

    public function deleteBy(array $array, bool $force = false): void;
}
