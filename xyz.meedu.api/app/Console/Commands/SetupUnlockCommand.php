<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use App\Meedu\SystemSetupLock;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SetupUnlockCommand extends Command
{
    protected $signature = 'setup:unlock {--force : 显式确认删除,生产环境强烈不建议}';

    protected $description = '删除超管初始化锁(storage/setup.lock),通常仅用于开发/测试环境复位';

    public function handle()
    {
        if (!$this->option('force')) {
            $this->warn('删除 setup.lock 会让公开的超管初始化接口重新开放,必须显式加 --force');
            return CommandAlias::FAILURE;
        }

        if (!SystemSetupLock::exists()) {
            $this->info('setup.lock 不存在,无需删除');
            return CommandAlias::SUCCESS;
        }

        if (!SystemSetupLock::delete()) {
            $this->error('setup.lock 删除失败,请检查文件权限');
            return CommandAlias::FAILURE;
        }

        $this->info('setup.lock 已删除');
        return CommandAlias::SUCCESS;
    }
}
