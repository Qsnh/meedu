<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Course\Proxies;

use App\Constant\CacheConstant;
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
            return new CacheInfo(
                get_cache_key(CacheConstant::VIDEO_SERVICE_COURSE_VIDEOS['name'], $courseId),
                $this->configService->getCacheExpire()
            );
        };
        $this->cache['getLatestVideos'] = function ($limit) {
            return new CacheInfo(
                get_cache_key(CacheConstant::VIDEO_SERVICE_LATEST['name'], $limit),
                $this->configService->getCacheExpire()
            );
        };
        $this->cache['simplePage'] = function (int $page, int $pageSize) {
            return new CacheInfo(
                get_cache_key(CacheConstant::VIDEO_SERVICE_PAGINATOR['name'], $page, $pageSize),
                $this->configService->getCacheExpire()
            );
        };
    }
}
