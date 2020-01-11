<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Course\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Course\Proxies\VideoServiceProxy;
use App\Services\Course\Proxies\CourseServiceProxy;
use App\Services\Course\Services\VideoCommentService;
use App\Services\Course\Services\CourseCommentService;
use App\Services\Course\Services\CourseCategoryService;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;
use App\Services\Course\Interfaces\CourseCategoryServiceInterface;

class CourseServiceRegisterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance(CourseServiceInterface::class, $this->app->make(CourseServiceProxy::class));
        $this->app->instance(VideoServiceInterface::class, $this->app->make(VideoServiceProxy::class));
        $this->app->instance(CourseCommentServiceInterface::class, $this->app->make(CourseCommentService::class));
        $this->app->instance(VideoCommentServiceInterface::class, $this->app->make(VideoCommentService::class));
        $this->app->instance(CourseCategoryServiceInterface::class, $this->app->make(CourseCategoryService::class));
    }
}
