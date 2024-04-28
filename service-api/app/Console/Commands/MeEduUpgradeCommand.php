<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use App\Meedu\Addons;
use App\Meedu\Core\Upgrade;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MeEduUpgradeCommand extends Command
{
    protected $signature = 'meedu:upgrade';

    protected $description = 'MeEdu升级处理命令';

    public function handle()
    {
        // 数据库迁移命令
        $this->info('执行数据库迁移...');
        Artisan::call('migrate', ['--force' => true]);

        // 同步最新配置
        $this->info('同步最新配置...');
        Artisan::call('install', ['action' => 'config']);

        // 同步管理角色和权限
        $this->info('同步后台管理权限...');
        Artisan::call('install', ['action' => 'role']);

        // 执行升级业务逻辑
        $this->info('执行升级业务逻辑...');
        (new Upgrade)->run();

        // 执行已安装插件的升级
        $enabledAddons = (new Addons())->enabledAddons();
        if ($enabledAddons) {
            $this->info('开始插件升级...');
            foreach ($enabledAddons as $addonSign) {
                $this->info(sprintf('插件%s正在升级...', $addonSign));
                // 插件升级的实际逻辑
                Artisan::call($addonSign, ['action' => 'upgrade']);
            }
        } else {
            $this->info('未检测到已启用插件，跳过升级');
        }

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
