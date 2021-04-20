<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Other\Proxies;

use App\Constant\CacheConstant;
use App\Meedu\ServiceProxy\ServiceProxy;
use App\Meedu\ServiceProxy\Cache\CacheInfo;
use App\Services\Other\Services\SliderService;
use App\Services\Other\Interfaces\SliderServiceInterface;

class SliderServiceProxy extends ServiceProxy implements SliderServiceInterface
{
    public function __construct(SliderService $service)
    {
        parent::__construct($service);
        $this->cache['all'] = function ($platform = '') {
            $platform || $platform = 'all';

            return new CacheInfo(
                get_cache_key(CacheConstant::SLIDER_SERVICE_ALL['name'], $platform),
                $this->configService->getCacheExpire()
            );
        };
    }
}
