<?php


namespace Tests\Feature\Api\V2;

use App\Constant\ApiV2Constant;
use Mews\Captcha\Captcha;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class CaptchaSmsTest extends Base
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        parent::setUp();
        $this->startMockery();
    }

    public function tearDown(): void
    {
        $this->closeMockery();
        parent::tearDown();
    }

public
function test_captcha_sms_with_no_error_image_captcha()
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

public
function test_captcha_sms_with_no_correct_image_captcha()
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