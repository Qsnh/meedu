<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Inc;

use App\Services\Base\Services\CacheService;
use App\Services\Base\Interfaces\CacheServiceInterface;

class Inc
{
    public static function record(IncItem $incItem): void
    {
        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);

        if ($cacheService->has($incItem->getKey())) {
            $val = $cacheService->inc($incItem->getKey());
        } else {
            $val = 1;
            $cacheService->forever($incItem->getKey(), $val);
        }
        $val >= $incItem->getLimit() && $incItem->save();
    }
}
