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

use App\Constant\CacheConstant;
use App\Meedu\ServiceProxy\ServiceProxy;
use App\Meedu\ServiceProxy\Cache\CacheInfo;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Interfaces\CourseServiceInterface;

class CourseServiceProxy extends ServiceProxy implements CourseServiceInterface
{
    public function __construct(CourseService $service)
    {
        parent::__construct($service);
        $this->cache['getLatestCourses'] = function ($limit) {
            return new CacheInfo(
                get_cache_key(CacheConstant::COURSE_SERVICE_LATEST['name'], $limit),
                $this->configService->getCacheExpire()
            );
        };
        $this->cache['chapters'] = function ($courseId) {
            return new CacheInfo(
                get_cache_key(CacheConstant::COURSE_SERVICE_CHAPTERS['name'], $courseId),
                $this->configService->getCacheExpire()
            );
        };
        $this->cache['simplePage'] = function (int $page, int $pageSize, int $categoryId = 0) {
            return new CacheInfo(
                get_cache_key(CacheConstant::COURSE_SERVICE_PAGINATOR['name'], $page, $pageSize, $categoryId),
                $this->configService->getCacheExpire()
            );
        };
    }
}
