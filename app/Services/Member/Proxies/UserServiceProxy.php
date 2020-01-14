<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Proxies;

use Illuminate\Support\Facades\Auth;
use App\Meedu\ServiceProxy\ServiceProxy;
use App\Meedu\ServiceProxy\Cache\CacheInfo;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class UserServiceProxy extends ServiceProxy implements UserServiceInterface
{
    public function __construct(UserService $service)
    {
        parent::__construct($service);

        $this->cache['getCurrentUserCourseCount'] = function () {
            return new CacheInfo('m:u:gcucc:' . Auth::id(), $this->configService->getCacheExpire());
        };
        $this->cache['getCurrentUserVideoCount'] = function () {
            return new CacheInfo('m:u:gcuvc:' . Auth::id(), $this->configService->getCacheExpire());
        };
    }
}
