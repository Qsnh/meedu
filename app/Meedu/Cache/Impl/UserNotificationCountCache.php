<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use Illuminate\Support\Facades\Cache;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class UserNotificationCountCache
{

    public const KEY_NAME = 'user-noti-c:%d';

    public const EXPIRE = 300;

    public function get(int $userId): int
    {
        $keyName = $this->key($userId);
        if (Cache::has($keyName)) {
            return (int)Cache::get($keyName);
        }
        /**
         * @var UserService $userService
         */
        $userService = app()->make(UserServiceInterface::class);
        $count = $userService->unreadNotificationCount($userId);
        Cache::put($keyName, $count);
        return $count;
    }

    private function key(int $userId): string
    {
        return sprintf(self::KEY_NAME, $userId);
    }

    public function destroy(int $userId)
    {
        return Cache::forget($this->key($userId));
    }
}
