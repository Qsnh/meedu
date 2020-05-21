<?php


namespace Tests\Commands;

use Tests\OriginalTestCase;

class InstallLockCommandTest extends OriginalTestCase
{

    public function test_run()
    {
        $this->artisan('install:lock');

        $this->assertTrue(file_exists(storage_path('install.lock')));

        @unlink(storage_path('install.lock'));
    }


}