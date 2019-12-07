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
use App\Meedu\AutoTool\Generator;

class AutoGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backend:api:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '后端api代码自动生成工具';

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
        $model = $this->ask('请输入model');
        $controller = $model.'Controller';
        $name = snake_case($model);
        $request = $this->ask('请输入Reqeust');
        $g = (new Generator())->setController($controller)->setModel($model)->setName($name)->setRequest($request);
        $g->genController();
        $g->genRoute();
    }
}
