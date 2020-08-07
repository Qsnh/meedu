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
use App\Services\Order\Models\PromoCode;

class PromoCodeTest extends Base
{
    public const MODEL = PromoCode::class;

    public const MODEL_NAME = 'promoCode';

    public const FILL_DATA = [
        'code' => 'MEEDU123',
        'invite_user_reward' => 11,
        'invited_user_reward' => 12,
        'use_times' => 10,
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

        $item->refresh();
        foreach (self::FILL_DATA as $key => $val) {
            if ($key === 'code') {
                continue;
            }
            $this->assertEquals($val, $item->{$key});
        }
    }

    public function test_destroy()
    {
        $item = factory(self::MODEL)->create();
        $response = $this->user($this->admin)->post(self::API_V1_PREFIX . '/' . self::MODEL_NAME . '/delete/multi', [
            'ids' => [$item->id],
        ]);
        $this->assertResponseSuccess($response);
        $model = self::MODEL;
        $this->assertEmpty($model::find($item->id));
    }
}
