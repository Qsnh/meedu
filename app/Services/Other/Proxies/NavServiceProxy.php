<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Proxies;

use App\Constant\CacheConstant;
use App\Meedu\ServiceProxy\ServiceProxy;
use App\Meedu\ServiceProxy\Cache\CacheInfo;
use App\Services\Other\Services\NavService;
use App\Services\Other\Interfaces\NavServiceInterface;

class NavServiceProxy extends ServiceProxy implements NavServiceInterface
{
    public function __construct(NavService $service)
    {
        parent::__construct($service);
        $this->cache['all'] = function ($platform) {
            return new CacheInfo(
                get_cache_key(CacheConstant::NAV_SERVICE_ALL['name'], $platform),
                $this->configService->getCacheExpire()
            );
        };
    }
}
