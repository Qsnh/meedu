<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Other\Proxies;

use App\Meedu\ServiceProxy\ServiceProxy;
use App\Meedu\ServiceProxy\Cache\CacheInfo;
use App\Services\Other\Services\AnnouncementService;

class AnnouncementServiceProxy extends ServiceProxy
{
    public function __construct(AnnouncementService $service)
    {
        parent::__construct($service);
        $this->cache['latest'] = function () {
            return new CacheInfo('anm:latest', $this->configService->getCacheExpire());
        };
    }
}
