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
use App\Services\Member\Models\User;
use App\Services\Base\Interfaces\CacheServiceInterface;

class RegisterMobileTest extends Base
{
    public function test_register_mobile_with_error_code()
    {
        $response = $this->postJson('/api/v2/register/mobile', [
            'mobile' => '13989897878',
            'mobile_code' => 'code',
        ]);
        $this->assertResponseError($response, __(ApiV2Constant::MOBILE_CODE_ERROR));
    }

    public function test_register_mobile_with_correct_code()
    {
        $cacheService = $this->app->make(CacheServiceInterface::class);
        $cacheService->put('m:13989897878', 'code', 10);
        $response = $this->postJson('/api/v2/register/mobile', [
            'mobile' => '13989897878',
            'mobile_code' => 'code',
        ]);
        $this->assertResponseSuccess($response);

        $this->assertTrue(User::whereMobile('13989897878')->exists());
    }

    public function test_register_mobile_with_exists_mobile()
    {
        $user = factory(User::class)->create(['mobile' => '13789890909']);
        $cacheService = $this->app->make(CacheServiceInterface::class);
        $cacheService->put('m:' . $user->mobile, 'code', 10);
        $response = $this->postJson('/api/v2/register/mobile', [
            'mobile' => $user->mobile,
            'mobile_code' => 'code',
        ]);
        $this->assertResponseError($response, __(ApiV2Constant::MOBILE_HAS_EXISTS));
    }
}
