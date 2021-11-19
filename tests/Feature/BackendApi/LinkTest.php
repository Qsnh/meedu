<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\BackendApi;

use App\Models\Administrator;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;
use App\Services\Other\Models\Link;

class LinkTest extends Base
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

    public function tearDown():void
    {
        $this->admin->delete();
        parent::tearDown();
    }

    public function test_index()
    {
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/link');
        $data = $this->assertResponseSuccess($response);
    }

    public function test_create()
    {
        $response = $this->user($this->admin)->post(self::API_V1_PREFIX . '/link', [
            'sort' => 1,
            'name' => 'meedu',
            'url' => 'http://meedu.vip',
        ]);
        $data = $this->assertResponseSuccess($response);
    }

    public function test_edit()
    {
        $link = Link::factory()->create();
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/link/' . $link->id);
        $data = $this->assertResponseSuccess($response);
        $this->assertEquals($link->name, $data['data']['name']);
    }

    public function test_update()
    {
        $link = Link::factory()->create([
            'name' => 1,
            'url' => 2,
            'sort' => 3
        ]);
        $response = $this->user($this->admin)->put(self::API_V1_PREFIX . '/link/' . $link->id, [
            'sort' => 1,
            'name' => 'meedu',
            'url' => 'http://meedu.vip',
        ]);
        $data = $this->assertResponseSuccess($response);

        $link->refresh();
        $this->assertEquals(1, $link->sort);
        $this->assertEquals('meedu', $link->name);
        $this->assertEquals('http://meedu.vip', $link->url);
    }

    public function test_destroy()
    {
        $link = Link::factory()->create();
        $response = $this->user($this->admin)->delete(self::API_V1_PREFIX . '/link/' . $link->id);
        $data = $this->assertResponseSuccess($response);
        $this->assertEmpty(Link::find($link->id));
    }
}
