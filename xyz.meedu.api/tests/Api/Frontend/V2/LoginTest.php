<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Frontend\V2;

use App\Constant\CacheConstant;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use Illuminate\Support\Str;

class LoginTest extends Base
{
    public function test_with_correct_password()
    {
        $user = User::factory()->create([
            'mobile' => '13890900909',
            'is_lock' => User::LOCK_NO,
        ]);
        $response = $this->postJson('/api/v2/login/password', $this->encryptBody([
            'mobile' => $user->mobile,
            'password' => '123456',
        ]));
        $this->assertResponseSuccess($response);
    }

    public function test_with_locked()
    {
        $user = User::factory()->create([
            'mobile' => '13890900909',
            'password' => Hash::make('123123'),
            'is_lock' => User::LOCK_YES,
        ]);
        $response = $this->postJson('/api/v2/login/password', $this->encryptBody([
            'mobile' => $user->mobile,
            'password' => '123123',
        ]));
        $this->assertResponseError($response, __('账号已被锁定'));
    }

    public function test_with_error_password()
    {
        $user = User::factory()->create([
            'mobile' => '13890900909',
            'is_lock' => User::LOCK_NO,
        ]);
        $response = $this->postJson('/api/v2/login/password', $this->encryptBody([
            'mobile' => $user->mobile,
            'password' => 'asd12312',
        ]));
        $this->assertResponseError($response, __('手机号或密码错误'));
    }

    public function test_mobile_login()
    {
        $mobile = '13890900909';
        $mobileCode = Str::random(6);

        /** @var CacheService $cacheService */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, $mobileCode, 100);

        $response = $this->postJson('/api/v2/login/mobile', $this->encryptBody([
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
        ]));
        $this->assertResponseSuccess($response);
    }
}
