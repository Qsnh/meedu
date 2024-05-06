<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V2;

use Illuminate\Support\Str;
use App\Constant\CacheConstant;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Interfaces\CacheServiceInterface;

class PasswordTest extends Base
{
    public function test()
    {
        $mobile = '18287829922';
        $oldPassword = '123123';
        $newPassword = '456456';
        $user = User::factory()->create(['mobile' => $mobile, 'password' => Hash::make($oldPassword)]);

        $mobileCode = Str::random(6);

        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, $mobileCode, 100);

        $response = $this->postJson('/api/v2/password/reset', [
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
            'password' => $newPassword,
        ]);
        $this->assertResponseSuccess($response);

        $user->refresh();
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    public function test_sms_error()
    {
        $mobile = '18287829922';
        $oldPassword = '123123';
        $newPassword = '456456';
        $user = User::factory()->create(['mobile' => $mobile, 'password' => Hash::make($oldPassword)]);

        $mobileCode = Str::random(6);

        $response = $this->postJson('/api/v2/password/reset', [
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
            'password' => $newPassword,
        ]);
        $this->assertResponseError($response, __('短信验证码错误'));
    }

    public function test_mobile_not_exists()
    {
        $mobile = '18287829922';
        $oldPassword = '123123';
        $newPassword = '456456';

        $mobileCode = Str::random(6);

        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, $mobileCode, 100);

        $response = $this->postJson('/api/v2/password/reset', [
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
            'password' => $newPassword,
        ]);
        $this->assertResponseError($response, __('手机号不存在'));
    }
}
