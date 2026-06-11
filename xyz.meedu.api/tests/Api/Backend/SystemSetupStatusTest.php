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
}
