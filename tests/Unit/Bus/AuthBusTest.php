<?php

/*
 * This file is part of the Qsnh/meedu.
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

    public function test_wechatMiniLogin()
    {
        $appId = Str::random(10);
        $userId = $this->authBus->wechatMiniLogin($appId, '');

        $this->assertEquals(0, $userId);
    }

    public function test_wechatMiniLogin_with_exist_user()
    {
        $appId = Str::random(10);

        $user = User::factory()->create();

        Socialite::create([
            'user_id' => $user['id'],
            'app' => FrontendConstant::WECHAT_MINI_LOGIN_SIGN,
            'app_user_id' => $appId,
            'union_id' => '',
        ]);

        $userId = $this->authBus->wechatMiniLogin($appId, '');

        $this->assertEquals($user['id'], $userId);
    }

    public function test_wechatMiniLogin_with_exist_user_and_unionId()
    {
        $appId = Str::random(10);
        $unionId = Str::random(10);

        $user = User::factory()->create();

        Socialite::create([
            'user_id' => $user['id'],
            'app' => FrontendConstant::WECHAT_MINI_LOGIN_SIGN,
            'app_user_id' => $appId,
            'union_id' => $unionId,
        ]);

        $userId = $this->authBus->wechatMiniLogin($appId, $unionId);

        $this->assertEquals($user['id'], $userId);
    }

    public function test_wechatMiniLogin_with_exist_user_and_unionId_bind()
    {
        $appId = Str::random(10);

        $user = User::factory()->create();

        Socialite::create([
            'user_id' => $user['id'],
            'app' => FrontendConstant::WECHAT_MINI_LOGIN_SIGN,
            'app_user_id' => $appId,
        ]);

        $userId = $this->authBus->wechatMiniLogin($appId, '');

        $unionId = Str::random(10);

        $userId2 = $this->authBus->wechatMiniLogin($appId, $unionId);

        $this->assertEquals($userId, $userId2);
    }

    public function test_wechatMiniMobileLogin()
    {
        $appId = Str::random(10);

        $mobile = '13899990002';
        $data = [
            'nickName' => 'haha',
            'avatarUrl' => 'https://mock.image',
        ];

        $user = $this->authBus->wechatMiniMobileLogin($appId, '', '13899990002', $data);

        $this->assertEquals($mobile, $user['mobile']);
        $this->assertEquals($data['nickName'], $user['nick_name']);
        $this->assertEquals($data['avatarUrl'], $user['avatar']);

        $socialite = Socialite::query()
            ->where('user_id', $user['id'])
            ->where('app', FrontendConstant::WECHAT_MINI_LOGIN_SIGN)
            ->firstOrFail();

        $this->assertEquals($appId, $socialite['app_user_id']);
    }

    public function test_wechatMiniMobileLogin_with_exist_user()
    {
        $appId = Str::random(10);

        $user = User::factory()->create();

        $data = [
            'nickName' => 'haha',
            'avatarUrl' => 'https://mock.image',
        ];

        $user = $this->authBus->wechatMiniMobileLogin($appId, '', $user['mobile'], $data);

        $socialite = Socialite::query()
            ->where('user_id', $user['id'])
            ->where('app', FrontendConstant::WECHAT_MINI_LOGIN_SIGN)
            ->firstOrFail();

        $this->assertEquals($appId, $socialite['app_user_id']);
    }

    public function test_wechatMiniMobileLogin_with_exist_user_and_has_bind()
    {
        $appId = Str::random(10);

        $user = User::factory()->create();

        Socialite::create([
            'user_id' => $user['id'],
            'app' => FrontendConstant::WECHAT_MINI_LOGIN_SIGN,
            'app_user_id' => $appId,
        ]);

        $data = [
            'nickName' => 'haha',
            'avatarUrl' => 'https://mock.image',
        ];

        $loginUser = $this->authBus->wechatMiniMobileLogin($appId, '', $user['mobile'], $data);

        $this->assertEquals($user['id'], $loginUser['id']);
    }
}
