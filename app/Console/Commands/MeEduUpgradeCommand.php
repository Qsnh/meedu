<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use App\Meedu\Upgrade;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MeEduUpgradeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meedu:upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MeEdu升级处理命令';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 数据库迁移命令
        $this->info('执行数据库迁移...');
        Artisan::call('migrate', ['--force' => true]);

        // 同步meedu最新配置
        $this->info('同步最新配置...');
        Artisan::call('install', ['action' => 'config']);

        // 同步管理角色和权限
        $this->info('同步后台管理权限...');
        Artisan::call('install', ['action' => 'role']);

        // 执行升级业务逻辑
        $this->info('执行升级业务逻辑...');
        (new Upgrade)->run();

        // 清空路由缓存
        $this->info('清除路由缓存...');
        Artisan::call('route:clear');

        // 清空配置缓存
        $this->info('清除配置缓存...');
        Artisan::call('config:clear');

        // 清空视图缓存
        $this->info('清除视图缓存...');
        Artisan::call('view:clear');

        return 0;
    }
}
