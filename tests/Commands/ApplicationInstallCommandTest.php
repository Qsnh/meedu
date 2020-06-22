<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Commands;

use Illuminate\Support\Str;
use Tests\OriginalTestCase;
use App\Models\Administrator;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\Hash;
use App\Models\AdministratorPermission;

class ApplicationInstallCommandTest extends OriginalTestCase
{
    public function test_install_administrator()
    {
        $this->artisan('install', ['action' => 'administrator'])
            ->expectsOutput('请先运行 [ php artisan install role ] 命令来初始化meedu的管理员权限数据。');
    }

    public function test_install_administrator_with_role()
    {
        AdministratorRole::create([
            'display_name' => '小滕测试',
            'slug' => config('meedu.administrator.super_slug'),
            'description' => '描述',
        ]);

        $email = Str::random() . '@gmail.com';
        $password = '123456';

        $this->artisan('install', ['action' => 'administrator'])
            ->expectsQuestion('请输入邮箱(默认：meedu@meedu.meedu):', $email)
            ->expectsQuestion('请输入密码(默认：meedu123):', $password)
            ->expectsQuestion('请再输入一次(默认：meedu123):', $password)
            ->expectsOutput('管理员初始化成功.')
            ->assertExitCode(0);

        // 断言管理员创建成功
        $adms = Administrator::whereEmail($email)->first();
        // 管理员记录存在
        $this->assertNotNull($adms);
        // 密码正确
        $this->assertTrue(Hash::check($password, $adms->password));
    }

    // 在执行install administrator的时候
    // 输入一个已经存在的邮箱
    // 这个时候会报错
    public function test_install_administrator_and_exits_email()
    {
        AdministratorRole::create([
            'display_name' => '小滕测试',
            'slug' => config('meedu.administrator.super_slug'),
            'description' => '描述',
        ]);

        $email = Str::random() . '@gmail.com';
        $password = '123456';

        Administrator::create([
            'name' => '123',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->artisan('install', ['action' => 'administrator'])
            ->expectsQuestion('请输入邮箱(默认：meedu@meedu.meedu):', $email)
            ->expectsOutput('邮箱已经存在');
    }

    public function test_install_administrator_and_password_not_correct()
    {
        AdministratorRole::create([
            'display_name' => '小滕测试',
            'slug' => config('meedu.administrator.super_slug'),
            'description' => '描述',
        ]);

        $email = Str::random() . '@gmail.com';
        $password = '123456';

        $this->artisan('install', ['action' => 'administrator'])
            ->expectsQuestion('请输入邮箱(默认：meedu@meedu.meedu):', $email)
            ->expectsQuestion('请输入密码(默认：meedu123):', $password)
            ->expectsQuestion('请再输入一次(默认：meedu123):', Str::random())
            ->expectsOutput('两次输入密码不一致.');
    }

    public function test_install_dev()
    {
        $this->artisan('install', ['action' => 'dev'])
            ->assertExitCode(0);
    }

    public function test_install_role()
    {
        $this->artisan('install', ['action' => 'role'])
            ->assertExitCode(0);

        // 断言已经创建了管理员的role
        $role = AdministratorRole::whereSlug(config('meedu.administrator.super_slug'))->first();
        $this->assertNotNull($role);

        // 断言权限
        $count = AdministratorPermission::count();
        $this->assertGreaterThan(0, $count);
    }
}
