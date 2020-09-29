<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Api\V2;

use App\Constant\ApiV2Constant;
use App\Constant\CacheConstant;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Interfaces\CacheServiceInterface;

class LoginTest extends Base
{
    public function test_with_correct_password()
    {
        $user = factory(User::class)->create([
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
        $user = factory(User::class)->create([
            'mobile' => '13890900909',
            'password' => Hash::make('123123'),
            'is_lock' => User::LOCK_YES,
        ]);
        $response = $this->postJson('/api/v2/login/password', [
            'mobile' => $user->mobile,
            'password' => '123123',
        ]);
        $this->assertResponseError($response, __(ApiV2Constant::MEMBER_HAS_LOCKED));
    }

    public function test_with_error_password()
    {
        $user = factory(User::class)->create([
            'mobile' => '13890900909',
            'is_lock' => User::LOCK_NO,
        ]);
        $response = $this->postJson('/api/v2/login/password', [
            'mobile' => $user->mobile,
            'password' => 'asd12312',
        ]);
        $this->assertResponseError($response, __(ApiV2Constant::MOBILE_OR_PASSWORD_ERROR));
    }

    public function test_mobile_login()
    {
        $mobile = '13890900909';
        $user = factory(User::class)->create([
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

    public function test_socialites()
    {
        config(['meedu.member.socialite.github.enabled' => 0]);
        config(['meedu.member.socialite.qq.enabled' => 1]);
        config(['meedu.member.socialite.weixinweb.enabled' => 0]);

        $response = $this->get('/api/v2/login/socialites');
        $response = $this->assertResponseSuccess($response);
        $apps = $response['data'];
        $apps = array_column($apps, null, 'app');
        $this->assertTrue(isset($apps['qq']));
        $this->assertFalse(isset($apps['github']));
        $this->assertFalse(isset($apps['weixinweb']));
    }
}
