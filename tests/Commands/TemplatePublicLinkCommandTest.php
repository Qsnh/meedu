<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Commands;

use Tests\OriginalTestCase;
use Illuminate\Filesystem\Filesystem;

class TemplatePublicLinkCommandTest extends OriginalTestCase
{
    public function test_run()
    {
        $this->artisan('template:public', ['template' => 'demo'])
            ->assertExitCode(0)
            ->expectsOutput('无需操作');

        $file = $this->app->make(Filesystem::class);
        $file->deleteDirectory(base_path('templates/demo'));
        $file->delete(base_path('public/templates/demo'));

        $file->makeDirectory(base_path('templates/demo/public'), 0755, true);
        $this->artisan('template:public', ['template' => 'demo'])
            ->assertExitCode(0)
            ->expectsOutput('success');

        $file->deleteDirectory(base_path('templates/demo'));
        $file->delete(base_path('public/templates/demo'));
    }
}
