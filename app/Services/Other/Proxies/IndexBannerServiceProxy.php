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
use App\Services\Other\Services\IndexBannerService;
use App\Services\Other\Interfaces\IndexBannerServiceInterface;

class IndexBannerServiceProxy extends ServiceProxy implements IndexBannerServiceInterface
{
    public function __construct(IndexBannerService $service)
    {
        parent::__construct($service);
        $this->cache['all'] = function () {
            return new CacheInfo('os:iba', $this->configService->getCacheExpire());
        };
    }
}
