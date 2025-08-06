<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V2;

use Tests\TestCase;
use App\Services\Base\Services\ConfigService;
use Illuminate\Support\Facades\Hash;

class RegisterTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->startMockery();
    }

    public function tearDown(): void
    {
        $this->closeMockery();
        parent::tearDown();
    }

    public function test_sms_register_with_missing_mobile()
    {
        $response = $this->postJson('/api/v2/register/sms', []);
        $this->assertResponseError($response, __('mobile.required'));
    }

    public function test_sms_register_with_missing_mobile_code()
    {
        $response = $this->postJson('/api/v2/register/sms', [
            'mobile' => '13800138000',
        ]);
        $this->assertResponseError($response, __('mobile_code.required'));
    }

    public function test_sms_register_with_missing_password()
    {
        $response = $this->postJson('/api/v2/register/sms', [
            'mobile' => '13800138000',
            'mobile_code' => '123456',
        ]);
        $this->assertResponseError($response, __('password.required'));
    }

    public function test_sms_register_with_password_length_less_than_6()
    {
        $response = $this->postJson('/api/v2/register/sms', [
            'mobile' => '13800138000',
            'mobile_code' => '123456',
            'password' => '12345',
        ]);
        $this->assertResponseError($response, __('password.min'));
    }

    public function test_sms_register_with_password_length_more_than_16()
    {
        $response = $this->postJson('/api/v2/register/sms', [
            'mobile' => '13800138000',
            'mobile_code' => '123456',
            'password' => '12345678901234567',
        ]);
        $this->assertResponseError($response, __('password.max'));
    }
}