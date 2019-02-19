<?php

namespace Tests\Feature\Page;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{

    public function test_visit_login_page()
    {
        $response = $this->get(route('login'));
        $response->assertResponseStatus(200);
        $response->see('登录');
        $response->see('忘记密码');
        $response->see('注册');
    }

    public function test_mock_user_login_success()
    {
        $password = 123456;
        $user = factory(User::class)->create([
            'password' => bcrypt($password),
        ]);
        $this->visit(route('login'))
            ->type($user->mobile, 'mobile')
            ->type($password, 'password')
            ->press('登录')
            ->seePageIs('/member');
    }

    public function test_mock_user_login_fail()
    {
        $user = factory(User::class)->create();
        $this->visit(route('login'))
            ->type($user->mobile, 'mobile')
            ->type($user->password, 'password')
            ->press('登录')
            ->seePageIs('/login');
    }

}
