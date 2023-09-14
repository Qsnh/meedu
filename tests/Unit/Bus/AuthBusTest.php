<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Bus;

use Tests\TestCase;
use App\Bus\AuthBus;
use Illuminate\Support\Str;
use App\Constant\FrontendConstant;
use App\Services\Member\Models\User;
use App\Services\Member\Models\Socialite;

class AuthBusTest extends TestCase
{

    /**
     * @var AuthBus
     */
    protected $authBus;

    public function setUp(): void
    {
        parent::setUp();
        $this->authBus = $this->app->make(AuthBus::class);
    }

    public function test_wechatLogin()
    {
        $appId = Str::random(10);
        $userId = $this->authBus->wechatLogin($appId, '', [
            'nickname' => '昵称',
            'avatar' => 'https://mock.url/image',
        ]);

        $this->assertNotEquals(0, $userId);

        $socialite = Socialite::query()
            ->where('user_id', $userId)
            ->where('app', FrontendConstant::WECHAT_LOGIN_SIGN)
            ->firstOrFail();

        $this->assertEquals($appId, $socialite['app_user_id']);
    }

    public function test_wechatLogin_with_exists_user()
    {
        $appId = Str::random(10);

        $user = User::factory()->create();

        Socialite::create([
            'user_id' => $user['id'],
            'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
            'app_user_id' => $appId,
        ]);

        $userId = $this->authBus->wechatLogin($appId, '', [
            'nickname' => '昵称',
            'avatar' => 'https://mock.url/image',
        ]);

        $this->assertEquals($user['id'], $userId);
    }

    public function test_wechatLogin_with_unionId()
    {
        $appId = Str::random(10);
        $unionId = Str::random(10);
        $userId = $this->authBus->wechatLogin($appId, $unionId, [
            'nickname' => '昵称',
            'avatar' => 'https://mock.url/image',
        ]);

        $this->assertNotEquals(0, $userId);

        $socialite = Socialite::query()
            ->where('user_id', $userId)
            ->where('app', FrontendConstant::WECHAT_LOGIN_SIGN)
            ->firstOrFail();

        $this->assertEquals($appId, $socialite['app_user_id']);
        $this->assertEquals($unionId, $socialite['union_id']);
    }

    public function test_wechatLogin_with_unionId_and_exists_user()
    {
        $appId = Str::random(10);
        $unionId = Str::random(10);

        $user = User::factory()->create();

        Socialite::create([
            'user_id' => $user['id'],
            'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
            'app_user_id' => $appId,
            'union_id' => $unionId,
        ]);

        $userId = $this->authBus->wechatLogin($appId, $unionId, [
            'nickname' => '昵称',
            'avatar' => 'https://mock.url/image',
        ]);

        $this->assertEquals($user['id'], $userId);
    }

    public function test_wechatLogin_with_exists_user_and_second_with_unionId()
    {
        $appId = Str::random(10);
        $userId = $this->authBus->wechatLogin($appId, '', [
            'nickname' => '昵称',
            'avatar' => 'https://mock.url/image',
        ]);

        $unionId = Str::random(10);

        $userId2 = $this->authBus->wechatLogin($appId, $unionId, [
            'nickname' => '昵称',
            'avatar' => 'https://mock.url/image',
        ]);

        $this->assertEquals($userId, $userId2);

        $socialite = Socialite::query()
            ->where('user_id', $userId)
            ->where('app', FrontendConstant::WECHAT_LOGIN_SIGN)
            ->firstOrFail();

        $this->assertEquals($unionId, $socialite['union_id']);
    }
}
