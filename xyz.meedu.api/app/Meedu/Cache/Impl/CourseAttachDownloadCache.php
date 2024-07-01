<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use Illuminate\Support\Facades\Cache;

class CourseAttachDownloadCache
{

    public const MAIN_KEY_PREFIX = 'course:attach:';
    public const MAIN_KEY_EXPIRE = 3600;

    public const LIMIT_kEY = 'user-course-attach-download-limit:%d';

    public function put(string $sign, array $data): void
    {
        Cache::put($this->key($sign), $data, self::MAIN_KEY_EXPIRE);
    }

    public function destroy(string $sign): void
    {
        Cache::forget($this->key($sign));
    }

    public function get(string $sign)
    {
        return Cache::get($this->key($sign));
    }

    public function key(string $sign): string
    {
        return self::MAIN_KEY_PREFIX . $sign;
    }

    public function incTimes(int $userId): void
    {
        $key = $this->getLimitKey($userId);
        if (Cache::has($key)) {
            Cache::increment($key);
        } else {
            Cache::add($key, 1, 3600);
        }
    }

    public function getTimes(int $userId)
    {
        return (int)Cache::get($this->getLimitKey($userId));
    }

    public function getLimitKey(int $userId): string
    {
        return sprintf(self::LIMIT_kEY, $userId);
    }

}
