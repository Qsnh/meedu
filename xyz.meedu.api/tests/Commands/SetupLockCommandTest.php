<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Commands;

use Tests\OriginalTestCase;
use App\Models\Administrator;

class SetupLockCommandTest extends OriginalTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        @unlink(storage_path('setup.lock'));
        @unlink(storage_path('setup.lock.tmp'));
    }

    public function tearDown(): void
    {
        @unlink(storage_path('setup.lock'));
        @unlink(storage_path('setup.lock.tmp'));
        parent::tearDown();
    }

    public function test_write_lock_when_admin_exists()
    {
        Administrator::factory()->create();

        $this->artisan('setup:lock')->assertExitCode(0);

        $this->assertTrue(file_exists(storage_path('setup.lock')));
        $payload = json_decode(file_get_contents(storage_path('setup.lock')), true);
        $this->assertEquals('cli', $payload['source']);
        $this->assertTrue($payload['admin_exists']);
        $this->assertFalse($payload['force']);
    }

    public function test_refuse_when_admin_table_empty_without_force()
    {
        $this->artisan('setup:lock')->assertExitCode(1);
        $this->assertFalse(file_exists(storage_path('setup.lock')));
    }

    public function test_force_allows_write_when_admin_table_empty()
    {
        $this->artisan('setup:lock', ['--force' => true])->assertExitCode(0);
        $this->assertTrue(file_exists(storage_path('setup.lock')));
        $payload = json_decode(file_get_contents(storage_path('setup.lock')), true);
        $this->assertTrue($payload['force']);
        $this->assertFalse($payload['admin_exists']);
    }

    public function test_idempotent_when_lock_already_exists()
    {
        file_put_contents(storage_path('setup.lock'), json_encode(['ts' => 1, 'source' => 'pre-existing']));

        $this->artisan('setup:lock')->assertExitCode(0);

        // 已存在的 lock 不应被覆盖
        $payload = json_decode(file_get_contents(storage_path('setup.lock')), true);
        $this->assertEquals('pre-existing', $payload['source']);
    }
}
