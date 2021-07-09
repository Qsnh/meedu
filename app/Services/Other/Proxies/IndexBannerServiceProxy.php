<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Proxies;

use App\Constant\CacheConstant;
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
            return new CacheInfo(
                get_cache_key(CacheConstant::INDEX_BANNER_SERVICE_ALL['name']),
                $this->configService->getCacheExpire()
            );
        };
    }
}
