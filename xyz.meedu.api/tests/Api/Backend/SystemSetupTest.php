<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Backend;

use App\Models\Administrator;
use App\Models\AdministratorLog;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\Hash;

class SystemSetupTest extends Base
{
    protected function setUp(): void
    {
        parent::setUp();
        AdministratorRole::query()->firstOrCreate(
            ['slug' => config('meedu.administrator.super_slug')],
            ['display_name' => '超级管理员', 'description' => '超管']
        );
    }

    public function test_valid_request_creates_super_admin()
    {
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'zhangsan@example.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);
        $data = $this->assertResponseSuccess($response);

        $this->assertEquals('zhangsan@example.com', $data['data']['email']);
        $this->assertEquals(1, Administrator::query()->count());

        $admin = Administrator::query()->first();
        $this->assertEquals('张三', $admin->name);
        $this->assertTrue(Hash::check('StrongPass123', $admin->password));

        $superSlug = config('meedu.administrator.super_slug');
        $this->assertTrue($admin->roles()->where('slug', $superSlug)->exists());

        // 审计日志必须落库,且 admin_id 归属到新建的超管自身(回归 #1048 admin_id NULL)
        $this->assertDatabaseHas('administrator_logs', [
            'admin_id' => $admin->id,
            'module'   => AdministratorLog::MODULE_ADMINISTRATOR,
            'opt'      => AdministratorLog::OPT_STORE,
        ]);
    }

    public function test_already_initialized_returns_business_error()
    {
        Administrator::factory()->create();

        $countBefore = Administrator::query()->count();
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'zhangsan@example.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);
        $this->assertResponseError($response, '系统已完成超管初始化');
        $this->assertEquals($countBefore, Administrator::query()->count());
    }

    public function test_missing_name_returns_validation_error()
    {
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'email' => 'a@b.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);
        $this->assertResponseError($response);
    }

    public function test_password_mismatch_returns_validation_error()
    {
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'a@b.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'OtherPass123',
        ]);
        $this->assertResponseError($response);
    }

    public function test_weak_password_returns_validation_error()
    {
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'a@b.com',
            'password' => 'onlyletters',
            'password_confirmation' => 'onlyletters',
        ]);
        $this->assertResponseError($response);
    }

    public function test_invalid_email_returns_validation_error()
    {
        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'not-an-email',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);
        $this->assertResponseError($response);
    }

    public function test_missing_super_role_returns_business_error()
    {
        AdministratorRole::query()->where('slug', config('meedu.administrator.super_slug'))->delete();

        $response = $this->postJson(self::API_V1_PREFIX . '/system/setup', [
            'name' => '张三',
            'email' => 'zhangsan@example.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);
        $this->assertResponseError($response);
        $this->assertEquals(0, Administrator::query()->count());
    }
}
