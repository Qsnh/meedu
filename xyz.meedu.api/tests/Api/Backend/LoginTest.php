<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Backend;

use Mockery;
use Mews\Captcha\Captcha;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

class LoginTest extends Base
{
    protected function setUp(): void
    {
        parent::setUp();
        @unlink(storage_path('setup.lock'));
    }

    protected function tearDown(): void
    {
        @unlink(storage_path('setup.lock'));
        parent::tearDown();
    }

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

        // 老站点自愈:首次成功登录后 setup.lock 自动补写
        $this->assertTrue(file_exists(storage_path('setup.lock')));
        $payload = json_decode(file_get_contents(storage_path('setup.lock')), true);
        $this->assertEquals('login_heal', $payload['source']);
        $this->assertEquals($administrator['email'], $payload['email']);
    }

    public function test_existing_lock_is_not_overwritten_on_login()
    {
        $administrator = Administrator::factory()->create([
            'password' => Hash::make('123123'),
        ]);
        file_put_contents(storage_path('setup.lock'), json_encode(['ts' => 1, 'source' => 'pre-existing']));

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

        $payload = json_decode(file_get_contents(storage_path('setup.lock')), true);
        $this->assertEquals('pre-existing', $payload['source']);
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
