<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Services;

use App\Services\Other\Models\IndexBanner;
use App\Services\Other\Interfaces\IndexBannerServiceInterface;

class IndexBannerService implements IndexBannerServiceInterface
{
    public function all(): array
    {
        return IndexBanner::query()->orderBy('sort')->get()->toArray();
    }
}
