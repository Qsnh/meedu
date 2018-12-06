<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallLockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:lock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate install lock.';

    /**
     * Create a new command instance.
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
        $lockDist = storage_path('install.lock');
        if (file_exists($lockDist)) {
            $this->warn('安装锁已经存在');

            return;
        }
        file_put_contents($lockDist, time());
        $this->info('安装锁生成成功');
    }
}
