<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Interfaces;

interface SearchRecordServiceInterface
{
    public function exists(string $resourceType, int $resourceId): bool;

    public function store(string $resourceType, int $resourceId, array $data): void;

    public function destroy(string $resourceType, int $resourceId): void;

    public function update(string $resourceType, int $resourceId, array $data): void;

    public function search(string $keywords, int $page = 1, int $size = 10, $type = ''): array;
}
