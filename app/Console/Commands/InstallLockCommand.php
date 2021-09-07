<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
    protected $description = '生成安装锁，防止已安装之后再次访问install.php';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (!file_exists(storage_path('install.lock'))) {
            file_put_contents(storage_path('install.lock'), time());
        }
        return 0;
    }
}
