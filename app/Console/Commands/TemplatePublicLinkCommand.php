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
use Illuminate\Filesystem\Filesystem;

class TemplatePublicLinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'template:public {template}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'template public resource link';

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

        $path = base_path('templates/' . $template . '/public');
        if (!is_dir($path)) {
            $this->line('无需操作');
            return;
        }

        $dist = base_path('public/templates/' . $template);
        if (!is_dir($dist)) {
            /**
             * @var $file Filesystem
             */
            $file = app()->make(Filesystem::class);
            $file->link($path, $dist);
        }

        $this->line('success');
    }
}
