<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Providers;

use App\Meedu\Setting;
use Illuminate\Support\Str;
use App\Meedu\ServiceV2\ServiceInit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\Base\Providers\BaseServiceRegisterProvider;
use App\Services\Order\Providers\OrderServiceRegisterProvider;
use App\Services\Other\Providers\OtherServiceRegisterProvider;
use App\Services\Course\Providers\CourseServiceRegisterProvider;
use App\Services\Member\Providers\MemberServiceRegisterProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // service-v2
        (new ServiceInit())->run();
        // 数据库
        Schema::defaultStringLength(191);
        // 自定义配置同步
        $this->app->make(Setting::class)->sync();
        // 日志链路
        $this->logInit();
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        // 服务注册
        $this->app->register(BaseServiceRegisterProvider::class);
        $this->app->register(MemberServiceRegisterProvider::class);
        $this->app->register(CourseServiceRegisterProvider::class);
        $this->app->register(OtherServiceRegisterProvider::class);
        $this->app->register(OrderServiceRegisterProvider::class);
    }

    protected function logInit()
    {
        // 日志链路配置
        $requestId = Str::random(12);
        $logger = $this->app->make('log');
        $logger->pushProcessor(function ($record) use ($requestId) {
            $record['extra']['request_id'] = $requestId;
            return $record;
        });
    }
}
