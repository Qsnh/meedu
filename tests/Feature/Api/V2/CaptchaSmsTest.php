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

use Mockery;
use Mews\Captcha\Captcha;
use App\Constant\ApiV2Constant;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class CaptchaSmsTest extends Base
{
    use MockeryPHPUnitIntegration;

    public function setUp():void
    {
        parent::setUp();
        $this->startMockery();
    }

    public function tearDown():void
    {
        $this->closeMockery();
        parent::tearDown();
    }

    public function test_captcha_sms_with_no_error_image_captcha()
    {
        $response = $this->postJson('/api/v2/captcha/sms', [
        'mobile' => '13890900909',
        'mobile_code' => '123456',
        'scene' => 'login',
        'image_key' => 'image_key',
        'image_captcha' => 'image_captcha',
    ]);
        $this->assertResponseError($response, __(ApiV2Constant::IMAGE_CAPTCHA_ERROR));
    }

    public function test_captcha_sms_with_no_correct_image_captcha()
    {
        // mock
        $captchaMock = Mockery::mock(Captcha::class);
        $captchaMock->shouldReceive('check_api')->withAnyArgs()->andReturnFalse();
        $this->app->instance(Captcha::class, $captchaMock);

        $response = $this->postJson('/api/v2/captcha/sms', [
        'mobile' => '13890900909',
        'mobile_code' => '123456',
        'scene' => 'login',
        'image_key' => '123456',
        'image_captcha' => 'image_captcha',
    ]);
        $this->assertResponseError($response, __('image_captcha_error'));
    }
}
