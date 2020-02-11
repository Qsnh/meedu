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

use App\Meedu\Setting;
use Illuminate\Console\Command;

class SwitchTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'template:switch {template}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '切换模板';

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
        $template = $this->argument('template');
        if ($template == 'default') {
            $path = resource_path('views');
        } else {
            $path = base_path('templates/' . $template);
            if (!is_dir($path)) {
                $this->warn('模板不存在');
                return;
            }
        }
        $config = [];
        $config['meedu.system.theme.use'] = $template;
        $config['meedu.system.theme.path'] = $path;
        app()->make(Setting::class)->append($config);
        $this->line('success');
    }
}
