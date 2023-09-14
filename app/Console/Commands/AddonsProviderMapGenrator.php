<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use App\Meedu\Addons;
use Illuminate\Console\Command;

class AddonsProviderMapGenrator extends Command
{
    protected $signature = 'addons:provider:map {except?}';

    protected $description = '重新生成已安装插件的map文件';


    public function handle()
    {
        $except = $this->argument('except');
        /**
         * @var $addons Addons
         */
        $addons = app()->make(Addons::class);
        $addons->reGenProvidersMap($except);

        return 0;
    }
}
