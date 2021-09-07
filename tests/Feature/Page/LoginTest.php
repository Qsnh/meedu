<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
        $response->see(__('登录'));
    }

    // 正确的手机号和密码登录时可以登录的
    public function test_mock_user_login_success()
    {
        $password = 123456;
        $user = User::factory()->create([
            'password' => Hash::make($password),
            'is_lock' => User::LOCK_NO,
        ]);
        $this->visit(route('login'))
            ->type($user->mobile, 'mobile')
            ->type($password, 'password')
            ->press(__('登录'))
            ->seePageIs('/');
    }

    // 错误的密码登录重定向到login界面
    public function test_mock_user_login_fail()
    {
        $user = User::factory()->create([
            'is_lock' => User::LOCK_YES,
        ]);
        $this->visit(route('login'))
            ->type($user->mobile, 'mobile')
            ->type($user->password, 'password')
            ->press(__('登录'))
            ->seePageIs('/login');
    }

    public function test_mock_user_with_locked()
    {
        $user = User::factory()->create([
            'is_lock' => User::LOCK_YES,
        ]);
        $this->visit(route('login'))
            ->type($user->mobile, 'mobile')
            ->type($user->password, 'password')
            ->press(__('登录'))
            ->seePageIs('/login');
    }
}
