<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Interfaces;

interface AnnouncementServiceInterface
{
    public function latest(): array;

    public function paginate($page, $size): array;

    public function findOrFail(int $id): array;

    public function viewTimesInc(int $id): void;
}
