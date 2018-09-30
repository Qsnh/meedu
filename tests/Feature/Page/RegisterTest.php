<?php

namespace Tests\Feature\Page;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{

    public function test_visit()
    {
        $response = $this->get(route('register'));
        $response->assertResponseStatus(200);
        $response->see('注册');
        $response->see('登录');
    }

    public function test_register_nick_name_repeat_fail()
    {
        $user = [
            'nick_name' => 'XiaoTeng',
            'mobile' => '13677778888',
            'password' => '123456',
        ];
        factory(User::class)->create([
            'nick_name' => $user['nick_name'],
        ]);
        $this->visit(route('register'))
            ->type($user['nick_name'], 'nick_name')
            ->type($user['mobile'], 'mobile')
            ->type($user['password'], 'password')
            ->type($user['password'], 'password_confirmation')
            ->press('注册')
            ->seePageIs(route('register'));
    }

    public function test_register_mobile_repeat_fail()
    {
        $user = [
            'nick_name' => 'XiaoTeng',
            'mobile' => '13677778888',
            'password' => '123456',
        ];
        factory(User::class)->create([
            'mobile' => $user['mobile'],
        ]);
        $this->visit(route('register'))
            ->type($user['nick_name'], 'nick_name')
            ->type($user['mobile'], 'mobile')
            ->type($user['password'], 'password')
            ->type($user['password'], 'password_confirmation')
            ->press('注册')
            ->seePageIs(route('register'));
    }

    public function register_mock_user_success()
    {
        $user = [
            'nick_name' => 'Xiaoteng',
            'mobile' => '13677778888',
            'password' => '123456',
        ];
        $this->visit(route('register'))
            ->type($user['nick_name'], 'nick_name')
            ->type($user['mobile'], 'mobile')
            ->type($user['password'], 'password')
            ->type($user['password'], 'password_confirmation')
            ->press('注册')
            ->seePageIs(route('login'));
    }


}
