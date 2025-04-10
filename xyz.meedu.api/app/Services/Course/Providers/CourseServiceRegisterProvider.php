<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Course\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Course\Proxies\VideoServiceProxy;
use App\Services\Course\Proxies\CourseServiceProxy;
use App\Services\Course\Services\CourseCategoryService;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Course\Interfaces\CourseCategoryServiceInterface;

class CourseServiceRegisterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance(CourseServiceInterface::class, $this->app->make(CourseServiceProxy::class));
        $this->app->instance(VideoServiceInterface::class, $this->app->make(VideoServiceProxy::class));
        $this->app->instance(CourseCategoryServiceInterface::class, $this->app->make(CourseCategoryService::class));
    }
}
