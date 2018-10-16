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
        Carbon::setLocale('zh');
        Schema::defaultStringLength(191);
        CourseComment::observe(CourseCommentObserver::class);
        Passport::routes();

        // 加载配置
        if (file_exists(config('meedu.save'))) {
            $config = json_decode(file_get_contents(config('meedu.save')));
            foreach ($config as $key => $item) {
                config([$key => $item]);
            }
        }
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
