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
use App\Models\CourseComment;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Observers\CourseCommentObserver;

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
        // 加载配置
        if (file_exists(config('meedu.save'))) {
            $config = json_decode(file_get_contents(config('meedu.save')));
            foreach ($config as $key => $item) {
                config([$key => $item]);
            }
        }
        // 短信服务注册
        config(['sms.default.gateways' => [config('meedu.system.sms')]]);
        // 注册视图默认命名空间
        $this->loadViewsFrom(resource_path('views'), 'default');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
