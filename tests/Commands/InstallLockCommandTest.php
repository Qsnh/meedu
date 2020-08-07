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

class InstallLockCommandTest extends OriginalTestCase
{
    public function setUp():void
    {
        parent::setUp();
        @unlink(storage_path('install.lock'));
    }

    public function tearDown():void
    {
        @unlink(storage_path('install.lock'));
        parent::tearDown();
    }

    public function test_run()
    {
        $this->artisan('install:lock');
        $this->assertTrue(file_exists(storage_path('install.lock')));
    }
}
