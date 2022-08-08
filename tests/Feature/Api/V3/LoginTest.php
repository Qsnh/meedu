<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V3;

use Illuminate\Support\Str;
use Tests\Feature\Api\V2\Base;
use App\Constant\CacheConstant;
use App\Constant\FrontendConstant;
use App\Meedu\ServiceV2\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Services\Member\Models\Socialite;

class LoginTest extends Base
{
    public function test_loginByCode_with_empty_code()
    {
        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => '',
        ]);
        $this->assertResponseError($response, __('参数错误'));
    }

    public function test_loginByCode_with_not_exists_code()
    {
        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => Str::random(16),
        ]);
        $this->assertResponseError($response, __('已过期'));
    }

    public function test_loginByCode_with_error_type_params()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite1',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        $this->assertResponseError($response, __('参数错误'));
    }

    public function test_loginByCode_with_empty_app_params()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => '',
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        $this->assertResponseError($response, __('参数错误'));
    }

    public function test_loginByCode_with_empty_openid_params()
    {
        // mock-data
        $code = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => '',
                'data' => [
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        $this->assertResponseError($response, __('参数错误'));
    }

    public function test_loginByCode_with_wechat_code()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        // mock-user
        $mockUser = User::factory()->create(['is_lock' => 0]);
        Socialite::create([
            'user_id' => $mockUser['id'],
            'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
            'app_user_id' => $openid,
            'data' => '',
            'union_id' => '',
        ]);

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        ['data' => $data] = $this->assertResponseSuccess($response);

        $payload = explode('.', $data['token']);
        $payload = json_decode(base64_decode($payload[1]), true);
        $this->assertEquals($mockUser['id'], $payload['sub']);
    }

    public function test_loginByCode_with_wechat_code_and_unionId()
    {
        // mock-data
        $code = Str::random(32);
        $unionId = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => Str::random(32),
                    'unionid' => $unionId,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        // mock-user
        $mockUser = User::factory()->create(['is_lock' => 0]);
        Socialite::create([
            'user_id' => $mockUser['id'],
            'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
            'app_user_id' => Str::random(32),//此处的openid与上面登录模拟的openid不一致但依旧能登录该账号
            'data' => '',
            'union_id' => $unionId,
        ]);

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        ['data' => $data] = $this->assertResponseSuccess($response);

        $payload = explode('.', $data['token']);
        $payload = json_decode(base64_decode($payload[1]), true);
        $this->assertEquals($mockUser['id'], $payload['sub']);
    }

    public function test_loginByCode_with_qq_code()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::SOCIALITE_APP_QQ,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        // mock-user
        $mockUser = User::factory()->create(['is_lock' => 0]);
        Socialite::create([
            'user_id' => $mockUser['id'],
            'app' => FrontendConstant::SOCIALITE_APP_QQ,
            'app_user_id' => $openid,
            'data' => '',
            'union_id' => '',
        ]);

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        ['data' => $data] = $this->assertResponseSuccess($response);

        $payload = explode('.', $data['token']);
        $payload = json_decode(base64_decode($payload[1]), true);
        $this->assertEquals($mockUser['id'], $payload['sub']);

        $this->assertFalse(Cache::has($cacheKey));
    }

    public function test_loginByCode_with_not_exists_user()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::SOCIALITE_APP_QQ,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        // mock-user
        Socialite::create([
            'user_id' => 123,
            'app' => FrontendConstant::SOCIALITE_APP_QQ,
            'app_user_id' => $openid,
            'data' => '',
            'union_id' => '',
        ]);

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        $this->assertResponseError($response, __('用户不存在'));
    }

    public function test_loginByCode_with_lock_user()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::SOCIALITE_APP_QQ,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        // mock-user
        $mockUser = User::factory()->create(['is_lock' => 1]);
        Socialite::create([
            'user_id' => $mockUser['id'],
            'app' => FrontendConstant::SOCIALITE_APP_QQ,
            'app_user_id' => $openid,
            'data' => '',
            'union_id' => '',
        ]);

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        $this->assertResponseError($response, __('用户已锁定无法登录'));
    }

    public function test_loginByCode_with_auto_create_user()
    {
        // 不强制绑定手机号
        config(['meedu.member.enabled_mobile_bind_alert' => 0]);

        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        ['data' => $data] = $this->assertResponseSuccess($response);

        // 读取创建的socialite记录
        $socialiteRecord = Socialite::query()
            ->where('app', FrontendConstant::WECHAT_LOGIN_SIGN)
            ->where('app_user_id', $openid)
            ->first();
        $this->assertNotNull($socialiteRecord);

        $payload = explode('.', $data['token']);
        $payload = json_decode(base64_decode($payload[1]), true);
        $this->assertEquals($socialiteRecord['user_id'], $payload['sub']);

        // 继续登录->不会创建新user
        $code = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );
        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        ['data' => $data] = $this->assertResponseSuccess($response);
        $payload = explode('.', $data['token']);
        $payload = json_decode(base64_decode($payload[1]), true);
        $this->assertEquals($socialiteRecord['user_id'], $payload['sub']);
    }

    public function test_loginByCode_with_enabled_bind_mobile()
    {
        // 不强制绑定手机号
        config(['meedu.member.enabled_mobile_bind_alert' => 1]);

        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        ['data' => $data] = $this->assertResponseSuccess($response);

        $this->assertEquals(1, $data['bind_mobile']);
        $this->assertEquals($code, $data['code']);
    }

    public function test_register_with_socialite_with_empty_params()
    {
        $response = $this->postJson('/api/v3/auth/register/socialite', [
            'code' => '',
            'mobile' => '',
        ]);
        $this->assertResponseError($response, __('参数错误'));
    }

    public function test_register_with_socialite()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $mobile = '13899990001';
        $mobileCode = '123123';
        Cache::put(get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile), $mobileCode, CacheConstant::MOBILE_CODE['expire']);

        $response = $this->postJson('/api/v3/auth/register/socialite', [
            'code' => $code,
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
        ]);
        ['data' => $data] = $this->assertResponseSuccess($response);

        $user = User::query()->where('mobile', $mobile)->first();
        $this->assertNotNull($user);

        // 返回的token是新注册用户的
        $payload = explode('.', $data['token']);
        $payload = json_decode(base64_decode($payload[1]), true);
        $this->assertEquals($user['id'], $payload['sub']);

        // socialite绑定的是新注册用户的
        $socialiteRecord = Socialite::query()->where('app', FrontendConstant::WECHAT_LOGIN_SIGN)->where('app_user_id', $openid)->first();
        $this->assertNotNull($socialiteRecord);
        $this->assertEquals($user['id'], $socialiteRecord['user_id']);

        // code已经删除
        $this->assertFalse(Cache::has($cacheKey));
    }

    public function test_register_with_socialite_with_error_code()
    {
        $mobile = '13899990001';
        $mobileCode = '123123';
        Cache::put(get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile), $mobileCode, CacheConstant::MOBILE_CODE['expire']);

        $response = $this->postJson('/api/v3/auth/register/socialite', [
            'code' => Str::random(32),
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
        ]);
        $this->assertResponseError($response, __('已过期'));
    }

    public function test_register_with_socialite_with_error_params()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $mobile = '13899990001';
        $mobileCode = '123123';
        Cache::put(get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile), $mobileCode, CacheConstant::MOBILE_CODE['expire']);

        $response = $this->postJson('/api/v3/auth/register/socialite', [
            'code' => $code,
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
        ]);
        $this->assertResponseError($response, __('参数错误'));
    }

    public function test_loginByCode_with_wechat_code_and_repeat()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        // mock-user
        $mockUser = User::factory()->create(['is_lock' => 0]);
        Socialite::create([
            'user_id' => $mockUser['id'],
            'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
            'app_user_id' => $openid,
            'data' => '',
            'union_id' => '',
        ]);

        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        $this->assertResponseSuccess($response);

        // 用相同的code再次去请求会失败
        $response = $this->postJson('/api/v3/auth/login/code', [
            'code' => $code,
        ]);
        $this->assertResponseError($response, __('已过期'));
    }

    public function test_register_with_socialite_and_repeat()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $mobile = '13899990001';
        $mobileCode = '123123';
        Cache::put(get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile), $mobileCode, CacheConstant::MOBILE_CODE['expire']);

        $response = $this->postJson('/api/v3/auth/register/socialite', [
            'code' => $code,
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
        ]);
        $this->assertResponseSuccess($response);

        $mobile = '13899990002';
        $mobileCode = '123456';
        Cache::put(get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile), $mobileCode, CacheConstant::MOBILE_CODE['expire']);

        $response = $this->postJson('/api/v3/auth/register/socialite', [
            'code' => $code,
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
        ]);
        $this->assertResponseError($response, __('已过期'));
    }

    public function test_register_with_socialite_and_exists_mobile()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $mobile = '13899990001';
        $mobileCode = '123123';
        Cache::put(get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile), $mobileCode, CacheConstant::MOBILE_CODE['expire']);

        User::factory()->create(['mobile' => $mobile]);

        $response = $this->postJson('/api/v3/auth/register/socialite', [
            'code' => $code,
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
        ]);
        $this->assertResponseError($response, __('手机号已存在'));
    }
}
