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
