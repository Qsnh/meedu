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
use App\Services\Other\Services\LinkService;
use App\Services\Other\Interfaces\LinkServiceInterface;

class LinkServiceProxy extends ServiceProxy implements LinkServiceInterface
{
    public function __construct(LinkService $service)
    {
        parent::__construct($service);
        $this->cache['all'] = function () {
            return new CacheInfo(
                CacheConstant::LINK_SERVICE_ALL['name'],
                $this->configService->getCacheExpire()
            );
        };
    }
}
