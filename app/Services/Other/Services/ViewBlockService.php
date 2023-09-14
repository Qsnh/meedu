<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Services;

use App\Services\Other\Models\ViewBlock;
use App\Services\Other\Interfaces\ViewBlockServiceInterface;

class ViewBlockService implements ViewBlockServiceInterface
{
    public function getPageBlocks(string $platform, string $page): array
    {
        return ViewBlock::query()
            ->select([
                'id', 'platform', 'page', 'sign', 'sort', 'config',
            ])
            ->where('platform', $platform)
            ->where('page', $page)
            ->orderBy('sort')
            ->get()
            ->toArray();
    }
}
