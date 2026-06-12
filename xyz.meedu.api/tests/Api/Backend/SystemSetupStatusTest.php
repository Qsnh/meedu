<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Backend;

use App\Models\Administrator;

class SystemSetupStatusTest extends Base
{
    protected function setUp(): void
    {
        parent::setUp();
        @unlink(storage_path('setup.lock'));
    }

    protected function tearDown(): void
    {
        @unlink(storage_path('setup.lock'));
        parent::tearDown();
    }

    public function test_admin_table_empty_returns_needs_init_true()
    {
        $response = $this->getJson(self::API_V1_PREFIX . '/system/setup-status');
        $data = $this->assertResponseSuccess($response);
        $this->assertTrue($data['data']['needs_init']);
    }

    public function test_admin_table_non_empty_returns_needs_init_false()
    {
        Administrator::factory()->create();

        $response = $this->getJson(self::API_V1_PREFIX . '/system/setup-status');
        $data = $this->assertResponseSuccess($response);
        $this->assertFalse($data['data']['needs_init']);
    }

    public function test_multiple_admins_returns_needs_init_false()
    {
        Administrator::factory()->count(2)->create();

        $response = $this->getJson(self::API_V1_PREFIX . '/system/setup-status');
        $data = $this->assertResponseSuccess($response);
        $this->assertFalse($data['data']['needs_init']);
    }

    public function test_setup_lock_present_returns_needs_init_false_even_when_admin_table_empty()
    {
        // lock 文件是权威哨兵:即便 administrators 表被清空也不应再走 needs_init 路径
        file_put_contents(storage_path('setup.lock'), json_encode(['ts' => time()]));

        $response = $this->getJson(self::API_V1_PREFIX . '/system/setup-status');
        $data = $this->assertResponseSuccess($response);
        $this->assertFalse($data['data']['needs_init']);
    }
}
