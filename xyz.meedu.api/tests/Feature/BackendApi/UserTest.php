<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\BackendApi;

use App\Models\Administrator;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;

class UserTest extends Base
{
    protected $admin;
    protected $role;

    public function setUp():void
    {
        parent::setUp();
        $this->admin = Administrator::factory()->create();
        $this->role = AdministratorRole::factory()->create();
        DB::table('administrator_role_relation')->insert([
            'administrator_id' => $this->admin->id,
            'role_id' => $this->role->id,
        ]);
    }

    public function test_user()
    {
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/user');
        $data = $this->assertResponseSuccess($response);
        $this->assertEquals($this->admin->email, $data['data']['email']);
    }
}
