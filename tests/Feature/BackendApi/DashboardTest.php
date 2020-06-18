<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\BackendApi;

use App\Meedu\MeEdu;
use App\Models\Administrator;

class DashboardTest extends Base
{
    public function test_dashboard()
    {
        $admin = factory(Administrator::class)->create();
        $response = $this->user($admin)->get(self::API_V1_PREFIX . '/dashboard');
        $this->assertResponseSuccess($response);
    }

    public function test_system_info()
    {
        $admin = factory(Administrator::class)->create();
        $response = $this->user($admin)->get(self::API_V1_PREFIX . '/dashboard/system/info');
        $data = $this->assertResponseSuccess($response);
        $this->assertEquals(PHP_VERSION, $data['data']['php_version']);
        $this->assertEquals(MeEdu::VERSION, $data['data']['meedu_version']);
    }
}
