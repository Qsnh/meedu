<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Page;

use Tests\TestCase;
use App\Services\Member\Models\User;

class RegisterTest extends TestCase
{
    public function test_visit()
    {
        $response = $this->get(route('register'));
        $response->assertResponseStatus(200);
        $response->see('注册');
        $response->see('登录');
    }

    public function test_submit()
    {
        $this->session(['sms_register' => 'smscode']);
        $this->visit(route('register'))
            ->type('nickname', 'nick_name')
            ->type('13900001111', 'mobile')
            ->type('smscode', 'sms_captcha')
            ->type('register', 'sms_captcha_key')
            ->type('meedu123', 'password')
            ->type('meedu123', 'password_confirmation')
            ->press('注册');

        $user = User::query()->where('mobile', '13900001111')->exists();
        $this->assertTrue($user);
    }

    public function test_submit_credit1_reward()
    {
        config(['meedu.member.credit1.register' => 112]);

        $this->session(['sms_register' => 'smscode']);
        $this->visit(route('register'))
            ->type('nickname', 'nick_name')
            ->type('13900001111', 'mobile')
            ->type('smscode', 'sms_captcha')
            ->type('register', 'sms_captcha_key')
            ->type('meedu123', 'password')
            ->type('meedu123', 'password_confirmation')
            ->press('注册');

        $user = User::query()->where('mobile', '13900001111')->first();
        $this->assertNotEmpty($user);
        $this->assertEquals(112, $user->credit1);
    }
}
