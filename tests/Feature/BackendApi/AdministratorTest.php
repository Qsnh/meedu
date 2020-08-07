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

use App\Models\Administrator;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;

class AdministratorTest extends Base
{
    public const MODEL = Administrator::class;

    public const MODEL_NAME = 'administrator';

    public const FILL_DATA = [
        'name' => '我是管理员',
        'email' => 'meedu@meedu.vip',
        'password' => '123123',
        'password_confirmation' => '123123',
    ];

    protected $admin;
    protected $role;

    public function setUp():void
    {
        parent::setUp();
        $this->admin = factory(Administrator::class)->create();
        $this->role = factory(AdministratorRole::class)->create();
        DB::table('administrator_role_relation')->insert([
            'administrator_id' => $this->admin->id,
            'role_id' => $this->role->id,
        ]);
    }

    public function tearDown():void
    {
        $this->admin->delete();
        parent::tearDown();
    }

    public function test_index()
    {
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/' . self::MODEL_NAME);
        $this->assertResponseSuccess($response);
    }

    public function test_create()
    {
        $response = $this->user($this->admin)->post(self::API_V1_PREFIX . '/' . self::MODEL_NAME, self::FILL_DATA);
        $this->assertResponseSuccess($response);
    }

    public function test_edit()
    {
        $item = factory(self::MODEL)->create();
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/' . self::MODEL_NAME . '/' . $item->id);
        $this->assertResponseSuccess($response);
    }

    public function test_update()
    {
        $item = factory(self::MODEL)->create();
        $response = $this->user($this->admin)->put(self::API_V1_PREFIX . '/' . self::MODEL_NAME . '/' . $item->id, self::FILL_DATA);
        $this->assertResponseSuccess($response);
    }

    public function test_destroy()
    {
        $item = factory(self::MODEL)->create();
        $response = $this->user($this->admin)->delete(self::API_V1_PREFIX . '/' . self::MODEL_NAME . '/' . $item->id);
        // 超管无法删除
        $this->assertResponseSuccess($response);
    }
}
