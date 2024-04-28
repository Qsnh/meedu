<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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

    public function get(string $key, $default = null)
    {
        return Cache::get($key, $default);
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

    public function inc(string $name, $inc = 1)
    {
        return Cache::increment($name, $inc);
    }

    public function has(string $name): bool
    {
        return Cache::has($name);
    }

    public function forever(string $name, $val): bool
    {
        return Cache::forever($name, $val);
    }

    public function add(string $key, $value, $expire)
    {
        return Cache::add($key, $value, $expire);
    }
}
