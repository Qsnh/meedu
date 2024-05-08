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

class RegisterTest extends Base
{
    public function test_register_ok()
    {
        $mobile = '18287829922';
        $password = Str::random(12);
        $mobileCode = Str::random(6);


        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, $mobileCode, 100);

        $response = $this->postJson('/api/v2/register/sms', [
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
            'password' => $password,
        ]);
        $this->assertResponseSuccess($response);

        $user = User::query()->where('mobile', $mobile)->first();
        $this->assertNotEmpty($user);
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertEquals(0, $user->is_set_nickname);
        $this->assertEquals(1, $user->is_password_set);
    }

    public function test_exists_mobile()
    {
        $mobile = '18287829922';
        $password = Str::random(12);
        $mobileCode = Str::random(6);

        User::factory()->create(['mobile' => $mobile]);

        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile);
        $cacheService->put($key, $mobileCode, 100);

        $response = $this->postJson('/api/v2/register/sms', [
            'mobile' => $mobile,
            'mobile_code' => $mobileCode,
            'password' => $password,
        ]);
        $this->assertResponseError($response, __('手机号已存在'));
    }
}
