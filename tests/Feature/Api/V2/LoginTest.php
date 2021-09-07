<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V2;

use App\Constant\CacheConstant;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Interfaces\CacheServiceInterface;

class LoginTest extends Base
{
    public function test_with_correct_password()
    {
        $user = User::factory()->create([
            'mobile' => '13890900909',
            'is_lock' => User::LOCK_NO,
        ]);
        $response = $this->postJson('/api/v2/login/password', [
            'mobile' => $user->mobile,
            'password' => '123456',
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_with_locked()
    {
        $user = User::factory()->create([
            'mobile' => '13890900909',
            'password' => Hash::make('123123'),
            'is_lock' => User::LOCK_YES,
        ]);
        $response = $this->postJson('/api/v2/login/password', [
            'mobile' => $user->mobile,
            'password' => '123123',
        ]);
        $this->assertResponseError($response, __('账号已被锁定'));
    }

    public function test_with_error_password()
    {
        $user = User::factory()->create([
            'mobile' => '13890900909',
            'is_lock' => User::LOCK_NO,
        ]);
        $response = $this->postJson('/api/v2/login/password', [
            'mobile' => $user->mobile,
            'password' => 'asd12312',
        ]);
        $this->assertResponseError($response, __('手机号或密码错误'));
    }

    public function test_mobile_login()
    {
        $mobile = '13890900909';
        $user = User::factory()->create([
            'mobile' => $mobile,
            'is_lock' => User::LOCK_NO,
        ]);

        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, '123456', 100);

        $response = $this->postJson('/api/v2/login/mobile', [
            'mobile' => $user->mobile,
            'mobile_code' => '123456',
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_mobile_login_with_not_exists_mobile()
    {
        $mobile = '13890900909';
        config(['meedu.member.is_lock_default' => User::LOCK_NO]);

        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, '123456', 100);

        $response = $this->postJson('/api/v2/login/mobile', [
            'mobile' => $mobile,
            'mobile_code' => '123456',
        ]);
        $this->assertResponseSuccess($response);
    }
}
