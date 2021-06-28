<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Base\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class BaseServiceRegisterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance(ConfigServiceInterface::class, $this->app->make(ConfigService::class));
        $this->app->instance(CacheServiceInterface::class, $this->app->make(CacheService::class));
    }
}
