<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\BackendApi;

use App\Meedu\MeEdu;
use App\Models\Administrator;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;

class DashboardTest extends Base
{
    protected $admin;
    protected $role;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = Administrator::factory()->create();
        $this->role = AdministratorRole::factory()->create();
        DB::table('administrator_role_relation')->insert([
            'administrator_id' => $this->admin->id,
            'role_id' => $this->role->id,
        ]);
    }

    public function tearDown(): void
    {
        $this->admin->delete();
        parent::tearDown();
    }

    public function test_dashboard()
    {
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/dashboard');
        $this->assertResponseSuccess($response);
    }

    public function test_system_info()
    {
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/dashboard/system/info');
        $data = $this->assertResponseSuccess($response);
        $this->assertEquals(PHP_VERSION, $data['data']['php_version']);
        $this->assertEquals(MeEdu::VERSION, $data['data']['meedu_version']);
    }
}
