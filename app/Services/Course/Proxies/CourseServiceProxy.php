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
use App\Services\Course\Services\CourseService;
use App\Services\Course\Interfaces\CourseServiceInterface;

class CourseServiceProxy extends ServiceProxy implements CourseServiceInterface
{
    public function __construct(CourseService $service)
    {
        parent::__construct($service);
        $this->cache['getLatestCourses'] = function ($limit) {
            return new CacheInfo('c:cs:lc:' . $limit, $this->configService->getCacheExpire());
        };
        $this->cache['chapters'] = function ($courseId) {
            return new CacheInfo('c:cs:cc:' . $courseId, $this->configService->getCacheExpire());
        };
        $this->cache['simplePage'] = function (int $page, int $pageSize, int $categoryId = 0) {
            return new CacheInfo('c:cs:sp:' . $page . '.' . $pageSize . '.' . $categoryId, $this->configService->getCacheExpire());
        };
    }
}
