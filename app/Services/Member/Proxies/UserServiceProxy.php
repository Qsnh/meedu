<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Proxies;

use App\Constant\CacheConstant;
use App\Meedu\ServiceProxy\ServiceProxy;
use App\Meedu\ServiceProxy\Cache\CacheInfo;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class UserServiceProxy extends ServiceProxy implements UserServiceInterface
{
    public function __construct(UserService $service)
    {
        parent::__construct($service);

        $this->cache['getUserCourseCount'] = function ($userId) {
            return new CacheInfo(
                get_cache_key(CacheConstant::USER_SERVICE_COURSE_COUNT['name'], $userId),
                $this->configService->getCacheExpire()
            );
        };
        $this->cache['getUserVideoCount'] = function ($userId) {
            return new CacheInfo(
                get_cache_key(CacheConstant::USER_SERVICE_VIDEO_COUNT['name'], $userId),
                $this->configService->getCacheExpire()
            );
        };
    }
}
