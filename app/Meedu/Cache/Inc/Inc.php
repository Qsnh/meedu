<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
