<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

interface FullSearchServiceInterface
{

    public function storeOrUpdate(string $resourceType, int $resourceId, string $title, string $thumb, int $charge, string $shortDesc, string $desc): void;

    public function delete(string $resourceType, int $resourceId): void;

    public function multiDelete(string $resourceType, array $resourceIds = []): void;

    public function clear(): void;

    public function search(string $keywords, int $page = 1, int $size = 10, string $type = ''): array;

    public function storeMulti(array $insectData): void;

    public function scoutImport(): void;
}
