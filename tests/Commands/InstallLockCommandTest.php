<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
