<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Base\Services;

use Illuminate\Support\Facades\Cache;
use App\Services\Base\Interfaces\CacheServiceInterface;

class CacheService implements CacheServiceInterface
{
    public function put(string $key, $value, $expire)
    {
        Cache::put($key, $value, $expire);
    }

    public function pull(string $key, $default = null)
    {
        return Cache::pull($key, $default);
    }

    public function lock(string $name, int $seconds)
    {
        return Cache::lock($name, $seconds);
    }
}
