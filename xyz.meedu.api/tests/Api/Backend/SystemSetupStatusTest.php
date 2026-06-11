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
    public function test_admin_table_empty_returns_needs_init_true()
    {
        // 清空 admin 表，模拟全新部署
        Administrator::query()->delete();

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
}
