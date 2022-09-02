<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Commands;

use Illuminate\Support\Str;
use Tests\OriginalTestCase;
use App\Models\Administrator;
use Illuminate\Console\Command;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\Hash;

class ApplicationInstallCommandTest extends OriginalTestCase
{
    public function test_install_with_acton_typo()
    {
        $this->artisan('install', ['action' => 'config1'])
            ->expectsOutput('action不存在')
            ->assertFailed();
    }

    public function test_install_config()
    {
        $this->artisan('install', ['action' => 'config'])
            ->assertSuccessful();
    }

    public function test_install_administrator()
    {
        $this->artisan('install', ['action' => 'administrator'])
            ->expectsOutput('请先运行 [ php artisan install role ] 命令来初始化meedu的管理员权限数据')
            ->assertFailed();
    }

    public function test_install_administrator_q()
    {
        $this->artisan('install', ['action' => 'role']);

        $this->artisan('install', ['action' => 'administrator', '--q' => true])
            ->expectsOutput('管理员初始化成功')
            ->assertSuccessful();

        $admin = Administrator::query()->where('email', 'meedu@meedu.meedu')->first();
        $this->assertNotNull($admin);
    }

    public function test_install_administrator_with_empty_email()
    {
        $this->artisan('install', ['action' => 'role']);

        $this->artisan('install', ['action' => 'administrator'])
            ->expectsQuestion('请输入邮箱(默认：meedu@meedu.meedu):', '')
            ->expectsOutput('邮箱不能空')
            ->assertFailed();
    }

    public function test_install_administrator_with_role()
    {
        $this->artisan('install', ['action' => 'role']);

        $email = Str::random() . '@gmail.com';
        $password = '123456';

        $this->artisan('install', ['action' => 'administrator'])
            ->expectsQuestion('请输入邮箱(默认：meedu@meedu.meedu):', $email)
            ->expectsQuestion('请输入密码(默认：meedu123):', $password)
            ->expectsQuestion('请再输入一次(默认：meedu123):', $password)
            ->expectsOutput('管理员初始化成功')
            ->assertExitCode(Command::SUCCESS);

        // 断言管理员创建成功
        $adms = Administrator::query()->where('email', $email)->first();
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
        $this->artisan('install', ['action' => 'role']);

        $email = Str::random() . '@gmail.com';
        $password = '123456';

        Administrator::create([
            'name' => '123',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->artisan('install', ['action' => 'administrator'])
            ->expectsQuestion('请输入邮箱(默认：meedu@meedu.meedu):', $email)
            ->expectsOutput('邮箱已经存在')
            ->assertFailed();
    }

    public function test_install_administrator_and_password_not_correct()
    {
        $this->artisan('install', ['action' => 'role']);

        $email = Str::random() . '@gmail.com';
        $password = '123456';

        $this->artisan('install', ['action' => 'administrator'])
            ->expectsQuestion('请输入邮箱(默认：meedu@meedu.meedu):', $email)
            ->expectsQuestion('请输入密码(默认：meedu123):', $password)
            ->expectsQuestion('请再输入一次(默认：meedu123):', Str::random())
            ->expectsOutput('两次输入密码不一致')
            ->assertFailed();
    }

    public function test_install_role()
    {
        $this->artisan('install', ['action' => 'role'])
            ->assertSuccessful();

        $role = AdministratorRole::query()->where('slug', config('meedu.administrator.super_slug'))->first();
        $this->assertNotNull($role);
    }
}
