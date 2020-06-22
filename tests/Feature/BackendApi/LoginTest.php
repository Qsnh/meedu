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
use Illuminate\Support\Facades\Hash;

class LoginTest extends Base
{
    public function test_with_correct_password()
    {
        $administrator = factory(Administrator::class)->create([
            'password' => Hash::make('123123'),
        ]);
        $response = $this->postJson(self::API_V1_PREFIX . '/login', [
            'username' => $administrator->email,
            'password' => '123123',
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_with_uncorrect_password()
    {
        $administrator = factory(Administrator::class)->create([
            'password' => Hash::make('123123'),
        ]);
        $response = $this->postJson(self::API_V1_PREFIX . '/login', [
            'username' => $administrator->email,
            'password' => '123456',
        ]);
        $this->assertResponseError($response);
    }

    public function test_with_uncorrect_username()
    {
        $administrator = factory(Administrator::class)->create([
            'email' => '111@meedu.vip',
            'password' => Hash::make('123123'),
        ]);
        $response = $this->postJson(self::API_V1_PREFIX . '/login', [
            'username' => '222@meedu.vip',
            'password' => '123123',
        ]);
        $this->assertResponseError($response);
    }
}
