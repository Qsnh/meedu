<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use App\Models\Administrator;
use App\Meedu\SystemSetupLock;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SetupLockCommand extends Command
{
    protected $signature = 'setup:lock {--force : 即便 administrators 表为空也强制写入}';

    protected $description = '生成超管初始化锁(storage/setup.lock),防止超管初始化接口被未授权重建';

    public function handle()
    {
        if (SystemSetupLock::exists()) {
            $this->info('setup.lock 已存在,无需重复写入');
            return CommandAlias::SUCCESS;
        }

        $adminExists = Administrator::query()->exists();
        if (!$adminExists && !$this->option('force')) {
            // 安全默认:没有超管也没有 --force 时拒绝写入,避免把未初始化的站点误锁死。
            $this->warn('administrators 表为空,拒绝写入 setup.lock;如确需强制写入请加 --force');
            return CommandAlias::FAILURE;
        }

        $ok = SystemSetupLock::write([
            'source' => SystemSetupLock::SOURCE_CLI,
            'admin_exists' => $adminExists,
            'force' => (bool) $this->option('force'),
        ]);
        if (!$ok) {
            $this->error('setup.lock 写入失败,请检查 storage 目录可写');
            return CommandAlias::FAILURE;
        }

        $this->info('setup.lock 写入成功');
        return CommandAlias::SUCCESS;
    }
}
