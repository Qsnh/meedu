<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V3;

use Illuminate\Support\Str;
use Tests\Feature\Api\V2\Base;
use App\Constant\CacheConstant;
use App\Constant\FrontendConstant;
use App\Meedu\ServiceV2\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Meedu\ServiceV2\Models\Socialite;
use App\Meedu\ServiceV2\Models\UserDeleteJob;

class MemberTest extends Base
{
    public function test_user_destroy()
    {
        $user = User::factory()->create(['is_lock' => 0]);
        $response = $this->user($user)->postJson('/api/v3/member/destroy', []);
        $this->assertResponseSuccess($response);
    }

    public function test_user_destroy_repeat_submit()
    {
        $user = User::factory()->create(['is_lock' => 0]);
        $response = $this->user($user)->postJson('/api/v3/member/destroy', []);
        $this->assertResponseSuccess($response);

        $response = $this->user($user)->postJson('/api/v3/member/destroy', []);
        $this->assertResponseError($response, __('用户已申请注销'));
    }

    public function test_user_login_and_cancel_user_delete()
    {
        $user = User::factory()->create(['is_lock' => 0, 'password' => Hash::make('123123')]);
        $response = $this->user($user)->postJson('/api/v3/member/destroy', []);
        $this->assertResponseSuccess($response);

        $response = $this->user($user)->postJson('/api/v2/login/password', [
            'mobile' => $user['mobile'],
            'password' => '123123',
        ]);
        $this->assertResponseSuccess($response);

        $job = UserDeleteJob::query()->where('user_id', $user['id'])->exists();
        $this->assertFalse($job);
    }

    public function test_socialite_bind_by_code_with_empty_code()
    {
        $user = User::factory()->create();
        $response = $this->user($user)->postJson('/api/v3/member/socialite/bindWithCode', [
            'code' => '',
        ]);
        $this->assertResponseError($response, __('参数错误'));
    }

    public function test_socialite_bind_by_code_with_normal_code()
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

        $user = User::factory()->create();
        $response = $this->user($user)->postJson('/api/v3/member/socialite/bindWithCode', [
            'code' => $code,
        ]);
        $this->assertResponseSuccess($response);

        $socialiteRecord = Socialite::query()->where('user_id', $user['id'])->where('app', FrontendConstant::WECHAT_LOGIN_SIGN)->where('app_user_id', $openid)->exists();
        $this->assertTrue($socialiteRecord);
    }

    public function test_socialite_bind_by_code_with_socialite_account_has_bind()
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

        Socialite::create([
            'user_id' => 111,
            'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
            'app_user_id' => $openid,
        ]);

        $user = User::factory()->create();
        $response = $this->user($user)->postJson('/api/v3/member/socialite/bindWithCode', [
            'code' => $code,
        ]);
        $this->assertResponseError($response, __('当前渠道账号已绑定了其它账号'));
    }

    public function test_socialite_bind_by_code_with_user_has_already_bind()
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

        $user = User::factory()->create();
        Socialite::create([
            'user_id' => $user['id'],
            'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
            'app_user_id' => Str::random(16),
        ]);

        $response = $this->user($user)->postJson('/api/v3/member/socialite/bindWithCode', [
            'code' => $code,
        ]);
        $this->assertResponseError($response, __('您已经绑定了该渠道的账号'));
    }

    public function test_socialite_bind_by_code_with_union_id()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $unionId = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'unionid' => $unionId,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $user = User::factory()->create();
        $response = $this->user($user)->postJson('/api/v3/member/socialite/bindWithCode', [
            'code' => $code,
        ]);
        $this->assertResponseSuccess($response);

        $socialiteRecord = Socialite::query()->where('user_id', $user['id'])->where('app', FrontendConstant::WECHAT_LOGIN_SIGN)->where('app_user_id', $openid)->first();
        $this->assertEquals($unionId, $socialiteRecord['union_id']);
    }

    public function test_socialite_bind_by_code_with_union_id_and_repeat()
    {
        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $unionId = Str::random(32);
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                'data' => [
                    'openid' => $openid,
                    'unionid' => $unionId,
                    'nickname' => '昵称',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $user = User::factory()->create();
        $response = $this->user($user)->postJson('/api/v3/member/socialite/bindWithCode', [
            'code' => $code,
        ]);
        $this->assertResponseSuccess($response);

        // mock-data
        $code = Str::random(32);
        $openid = Str::random(32);
        $app = 'wechat-app';
        $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
        Cache::put(
            $cacheKey,
            serialize([
                'type' => 'socialite',
                'app' => $app,
                'data' => [
                    'openid' => $openid,
                    'unionid' => $unionId,
                    'nickname' => '昵称-app',
                    'avatar' => 'https://mock.com/mock.png',
                    'original' => [],
                ],
            ]),
            CacheConstant::USER_SOCIALITE_LOGIN['expire']
        );

        $response = $this->user($user)->postJson('/api/v3/member/socialite/bindWithCode', [
            'code' => $code,
        ]);
        $this->assertResponseSuccess($response);

        $socialites = Socialite::query()->where('user_id', $user['id'])->whereIn('app', [FrontendConstant::WECHAT_LOGIN_SIGN, $app])->get()->pluck('app')->toArray();
        $this->assertEquals([FrontendConstant::WECHAT_LOGIN_SIGN, $app], $socialites);
    }
}
