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
use App\Services\Other\Models\AdFrom;

class AdFromTest extends Base
{
    public const MODEL = AdFrom::class;

    public const MODEL_NAME = 'ad_from';

    public const FILL_DATA = [
        'from_name' => 'from_name',
        'from_key' => 'from_key',
    ];

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
        $item = AdFrom::factory()->create();
        $response = $this->user($this->admin)->get(self::API_V1_PREFIX . '/' . self::MODEL_NAME . '/' . $item->id);
        $this->assertResponseSuccess($response);
    }

    public function test_update()
    {
        $item = AdFrom::factory()->create();
        $response = $this->user($this->admin)->put(self::API_V1_PREFIX . '/' . self::MODEL_NAME . '/' . $item->id, self::FILL_DATA);
        $this->assertResponseSuccess($response);

        $item->refresh();
        foreach (self::FILL_DATA as $key => $val) {
            $this->assertEquals($val, $item->{$key});
        }
    }

    public function test_destroy()
    {
        $item = AdFrom::factory()->create();
        $response = $this->user($this->admin)->delete(self::API_V1_PREFIX . '/' . self::MODEL_NAME . '/' . $item->id);
        $this->assertResponseSuccess($response);
        $model = self::MODEL;
        $this->assertEmpty($model::find($item->id));
    }
}
