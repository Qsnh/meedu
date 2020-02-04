<?php


namespace Tests\Feature\Api\V2;


use App\Constant\ApiV2Constant;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Base\Services\CacheService;
use App\Services\Member\Models\User;

class LoginTest extends Base
{

    public function test_with_correct_password()
    {
        $user = factory(User::class)->create([
            'mobile' => '13890900909',
        ]);
        $response = $this->postJson('/api/v2/login/password', [
            'mobile' => $user->mobile,
            'password' => '123456',
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_with_error_password()
    {
        $user = factory(User::class)->create([
            'mobile' => '13890900909',
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
        ]);

        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = sprintf(ApiV2Constant::MOBILE_CODE_CACHE_KEY, $mobile);
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

        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $key = sprintf(ApiV2Constant::MOBILE_CODE_CACHE_KEY, $mobile);
        $cacheService->put($key, '123456', 100);

        $response = $this->postJson('/api/v2/login/mobile', [
            'mobile' => $mobile,
            'mobile_code' => '123456',
        ]);
        $this->assertResponseSuccess($response);
    }

}