<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console;

use App\Meedu\Schedule\ScheduleContainer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\SetRequestForConsole::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \App\Meedu\AddonsProvider::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @codeCoverageIgnore
     */
    protected function schedule(Schedule $schedule)
    {
        // 订单超时处理
        $schedule->command('order:pay:timeout')
            ->onOneServer()
            ->everyThirtyMinutes()
            ->appendOutputTo(storage_path('logs/order_pay_timeout.log'));

        // 会员过期处理
        $schedule->command('member:role:expired')
            ->onOneServer()
            ->hourly()
            ->appendOutputTo(storage_path('logs/user_role_expired.log'));

        // 订单退款查询处理
        $schedule->command('meedu:refund:query')
            ->onOneServer()
            ->everyFiveMinutes()
            ->appendOutputTo(storage_path('logs/order_refund.log'));

        // 用户注销任务
        $schedule->command('meedu:user-delete-job')
            ->onOneServer()
            ->everyThirtyMinutes()
            ->appendOutputTo(storage_path('logs/user-delete-job.log'));

        // 全文搜索课程索引任务=>定时同步课程上架时间已到的课程
        $schedule->command('meedu:full-search:published-courses-index')
            ->onOneServer()
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/full_search_published_course_index.log'));

        // 预留定时任务钩子
        ScheduleContainer::instance()->exec($schedule);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}
