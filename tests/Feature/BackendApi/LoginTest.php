<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\BackendApi;

use Mockery;
use Mews\Captcha\Captcha;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

class LoginTest extends Base
{
    public function test_with_correct_password()
    {
        $administrator = Administrator::factory()->create([
            'password' => Hash::make('123123'),
        ]);

        // mock
        $captchaMock = Mockery::mock(Captcha::class);
        $captchaMock->shouldReceive('check_api')->withAnyArgs()->andReturnTrue();
        $this->app->instance(Captcha::class, $captchaMock);

        $response = $this->postJson(self::API_V1_PREFIX . '/login', [
            'username' => $administrator['email'],
            'password' => '123123',
            'image_key' => 'image_key',
            'image_captcha' => 'image_captcha',
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_with_uncorrect_password()
    {
        $administrator = Administrator::factory()->create([
            'password' => Hash::make('123123'),
        ]);

        // mock
        $captchaMock = Mockery::mock(Captcha::class);
        $captchaMock->shouldReceive('check_api')->withAnyArgs()->andReturnTrue();
        $this->app->instance(Captcha::class, $captchaMock);

        $response = $this->postJson(self::API_V1_PREFIX . '/login', [
            'username' => $administrator['email'],
            'password' => '123456',
            'image_key' => 'image_key',
            'image_captcha' => 'image_captcha',
        ]);
        $this->assertResponseError($response);
    }

    public function test_with_uncorrect_username()
    {
        Administrator::factory()->create([
            'email' => '111@meedu.vip',
            'password' => Hash::make('123123'),
        ]);

        // mock
        $captchaMock = Mockery::mock(Captcha::class);
        $captchaMock->shouldReceive('check_api')->withAnyArgs()->andReturnTrue();
        $this->app->instance(Captcha::class, $captchaMock);

        $response = $this->postJson(self::API_V1_PREFIX . '/login', [
            'username' => '222@meedu.vip',
            'password' => '123123',
            'image_key' => 'image_key',
            'image_captcha' => 'image_captcha',
        ]);
        $this->assertResponseError($response);
    }
}
