<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class CommentStoreLimitCache
{
    public const KEY_PREFIX = 'user_comment_count';
    public const DAILY_LIMIT = 100;

    public function getUserDailyCommentCount(int $userId): int
    {
        return (int)Cache::get($this->getDailyKey($userId), 0);
    }

    public function incrementUserDailyCommentCount(int $userId): void
    {
        $key = $this->getDailyKey($userId);
        Cache::increment($key);
        $cacheStore = Cache::getStore();
        $fullKey = $cacheStore->getPrefix() . $key;
        // redis连接
        $conn = $cacheStore->connection();
        // 读取过期时间
        $ttl = (int)$conn->ttl($fullKey);
        // 存在键但是未配置过期时间
        if (-1 === $ttl) {
            $conn->expire($fullKey, Carbon::parse(Carbon::now()->addDay()->format('Y-m-d 00:00:00'))->timestamp - time());
        }
    }

    public function canComment(int $userId): bool
    {
        return $this->getUserDailyCommentCount($userId) < self::DAILY_LIMIT;
    }

    private function getDailyKey(int $userId): string
    {
        return sprintf('%s:%d:%s', self::KEY_PREFIX, $userId, date('Y-m-d'));
    }
}
