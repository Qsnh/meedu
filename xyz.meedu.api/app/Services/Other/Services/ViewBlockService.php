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
    public function getPageBlocksByPageId(int $pageId): array
    {
        return ViewBlock::query()
            ->select(['id', 'platform', 'page', 'decoration_page_id', 'sign', 'sort', 'config'])
            ->where('decoration_page_id', $pageId)
            ->orderBy('sort')
            ->get()
            ->toArray();
    }
}
