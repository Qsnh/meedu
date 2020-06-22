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
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{

    // 可以访问登录界面
    public function test_visit_login_page()
    {
        $response = $this->get(route('login'));
        $response->assertResponseStatus(200);
        $response->see('登录');
        $response->see('忘记密码');
        $response->see('注册');
    }

    // 正确的手机号和密码登录时可以登录的
    public function test_mock_user_login_success()
    {
        $password = 123456;
        $user = factory(User::class)->create([
            'password' => Hash::make($password),
            'is_lock' => User::LOCK_NO,
        ]);
        $this->visit(route('login'))
            ->type($user->mobile, 'mobile')
            ->type($password, 'password')
            ->press('登录')
            ->seePageIs('/');
    }

    // 错误的密码登录重定向到login界面
    public function test_mock_user_login_fail()
    {
        $user = factory(User::class)->create([
            'is_lock' => User::LOCK_YES,
        ]);
        $this->visit(route('login'))
            ->type($user->mobile, 'mobile')
            ->type($user->password, 'password')
            ->press('登录')
            ->seePageIs('/login');
    }

    public function test_mock_user_with_locked()
    {
        $user = factory(User::class)->create([
            'is_lock' => User::LOCK_YES,
        ]);
        $this->visit(route('login'))
            ->type($user->mobile, 'mobile')
            ->type($user->password, 'password')
            ->press('登录')
            ->seePageIs('/login');
    }
}
