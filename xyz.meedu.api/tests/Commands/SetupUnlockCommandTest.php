<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Commands;

use Tests\OriginalTestCase;

class SetupUnlockCommandTest extends OriginalTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        @unlink(storage_path('setup.lock'));
    }

    public function tearDown(): void
    {
        @unlink(storage_path('setup.lock'));
        parent::tearDown();
    }

    public function test_refuse_without_force()
    {
        file_put_contents(storage_path('setup.lock'), json_encode(['ts' => 1]));

        $this->artisan('setup:unlock')->assertExitCode(1);

        // 未传 --force 不得删除
        $this->assertTrue(file_exists(storage_path('setup.lock')));
    }

    public function test_force_deletes_existing_lock()
    {
        file_put_contents(storage_path('setup.lock'), json_encode(['ts' => 1]));

        $this->artisan('setup:unlock', ['--force' => true])->assertExitCode(0);

        $this->assertFalse(file_exists(storage_path('setup.lock')));
    }

    public function test_force_is_noop_when_lock_missing()
    {
        $this->artisan('setup:unlock', ['--force' => true])->assertExitCode(0);
        $this->assertFalse(file_exists(storage_path('setup.lock')));
    }
}
