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

use App\Constant\CacheConstant;
use App\Meedu\ServiceProxy\ServiceProxy;
use App\Meedu\ServiceProxy\Cache\CacheInfo;
use App\Services\Other\Services\AnnouncementService;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;

class AnnouncementServiceProxy extends ServiceProxy implements AnnouncementServiceInterface
{
    public function __construct(AnnouncementService $service)
    {
        parent::__construct($service);
        $this->cache['latest'] = function () {
            return new CacheInfo(
                CacheConstant::ANNOUNCEMENT_SERVICE_LATEST['name'],
                $this->configService->getCacheExpire()
            );
        };
    }
}
