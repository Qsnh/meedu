<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\Bus;

use Tests\OriginalTestCase;
use App\Constant\FrontendConstant;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginLimitTest extends OriginalTestCase
{
    public function test_no_limit()
    {
        // 将登录限制改为[不限制]
        config(['meedu.system.login.limit.rule' => FrontendConstant::LOGIN_LIMIT_RULE_DEFAULT]);

        $user = User::factory()->create([
            'mobile' => '13899990001',
            'password' => Hash::make('123123'),
            'is_lock' => 0,
        ]);

        // 第一次登录
        $response = $this->post('/api/v2/login/password', [
            'mobile' => $user['mobile'],
            'password' => '123123',
        ]);
        $content = $this->assertResponseOk($response);
        $token1 = $content['data']['token'];

        // 第二次登录
        $response = $this->post('/api/v2/login/password', [
            'mobile' => $user['mobile'],
            'password' => '123123',
        ]);
        $content = $this->assertResponseOk($response);
        $token2 = $content['data']['token'];

        // token1依旧有效
        $response = $this->get('/api/v2/member/detail', [
            'Authorization' => 'Bearer ' . $token1,
        ]);
        $content = $this->assertResponseOk($response);
        $this->assertEquals('13899990001', $content['data']['mobile']);

        // token2依旧有效
        $response = $this->get('/api/v2/member/detail', [
            'Authorization' => 'Bearer ' . $token2,
        ]);
        $content = $this->assertResponseOk($response);
        $this->assertEquals('13899990001', $content['data']['mobile']);
    }

    public function test_login_limit()
    {
        // 将登录限制改为[仅允许一台设备登录]
        config(['meedu.system.login.limit.rule' => FrontendConstant::LOGIN_LIMIT_RULE_ALL]);

        $user = User::factory()->create([
            'mobile' => '13899990002',
            'password' => Hash::make('123123'),
            'is_lock' => 0,
        ]);

        // 第一次登录
        $response = $this->post('/api/v2/login/password', [
            'mobile' => $user['mobile'],
            'password' => '123123',
        ]);
        $content = $this->assertResponseOk($response);
        $token1 = $content['data']['token'];

        // 第二次登录
        $response = $this->post('/api/v2/login/password', [
            'mobile' => $user['mobile'],
            'password' => '123123',
        ]);
        $content = $this->assertResponseOk($response);
        $token2 = $content['data']['token'];

        // token1已经无效
        $response = $this->get('/api/v2/member/detail', [
            'Authorization' => 'Bearer ' . $token1,
        ]);
        $this->assertResponseCode401($response);

        // token2是有效的
        $response = $this->get('/api/v2/member/detail', [
            'Authorization' => 'Bearer ' . $token2,
        ]);
        $content = $this->assertResponseOk($response);
        $this->assertEquals('13899990002', $content['data']['mobile']);
    }
}
