<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Interfaces;

interface ViewBlockServiceInterface
{
    public function getPageBlocks(string $platform, string $page): array;
}
