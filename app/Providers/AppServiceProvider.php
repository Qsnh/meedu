<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Providers;

use Carbon\Carbon;
use App\Meedu\Setting;
use App\Models\CourseComment;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Observers\CourseCommentObserver;
use App\Services\Other\Providers\OtherServiceRegisterProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // 中文
        Carbon::setLocale('zh');
        // 数据库
        Schema::defaultStringLength(191);
        // 模型事件
        CourseComment::observe(CourseCommentObserver::class);
        // OAuth路由
        Passport::routes();
        // 自定义配置同步
        $this->app->make(Setting::class)->sync();
        $this->registerViewNamespace();
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        if ($this->app->environment(['dev'])) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        // 注册服务
        $this->app->register(OtherServiceRegisterProvider::class);
    }

    /**
     * 注册视图.
     */
    protected function registerViewNamespace()
    {
        $this->loadViewsFrom(config('meedu.system.theme.path'), config('meedu.system.theme.use'));
    }
}
