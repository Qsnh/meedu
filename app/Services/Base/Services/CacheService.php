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

use App\Services\Base\Interfaces\CacheServiceInterface;
use Illuminate\Support\Facades\Cache;

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

    public function forget(string $name): void
    {
        Cache::forget($name);
    }

    public function inc(string $name, $inc = 1): void
    {
        Cache::increment($name, $inc);
    }

    public function has(string $name): bool
    {
        return Cache::has($name);
    }
}
