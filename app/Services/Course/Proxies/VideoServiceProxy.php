<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Course\Proxies;

use App\Meedu\ServiceProxy\ServiceProxy;
use App\Meedu\ServiceProxy\Cache\CacheInfo;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Interfaces\VideoServiceInterface;

class VideoServiceProxy extends ServiceProxy implements VideoServiceInterface
{
    public function __construct(VideoService $service)
    {
        parent::__construct($service);
        $this->cache['courseVideos'] = function ($courseId) {
            return new CacheInfo('cs:vs:c:' . $courseId, $this->configService->getCacheExpire());
        };
        $this->cache['getLatestVideos'] = function () {
            return new CacheInfo('cs:vs:lv', $this->configService->getCacheExpire());
        };
        $this->cache['simplePage'] = function (int $page, int $pageSize) {
            return new CacheInfo('cs:vs:sp:' . $page . '.' . $pageSize, $this->configService->getCacheExpire());
        };
    }
}
