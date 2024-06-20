<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use App\Models\Administrator;
use Illuminate\Console\Command;
use Illuminate\Database\Seeder;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\AppConfigSeeder;
use Database\Seeders\AdministratorSuperSeeder;
use Database\Seeders\AdministratorPermissionSeeder;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ApplicationInstallCommand extends Command
{
    protected $signature = 'install {action} {--q}';

    protected $description = 'MeEdu程序安装命令';

    public function handle()
    {
        $action = $this->argument('action');

        $method = 'action' . implode('', array_map('ucfirst', explode('_', $action)));
        if (!method_exists($this, $method)) {
            $this->warn('action不存在');
            return CommandAlias::FAILURE;
        }

        return $this->{$method}();
    }

    public function actionAdministratorOnce()
    {
        if (Administrator::query()->count() > 0) {
            $this->warn('系统默认管理员已初始化!');
            return CommandAlias::SUCCESS;
        }

        $super = AdministratorRole::query()->where('slug', config('meedu.administrator.super_slug'))->first();
        if (!$super) {
            $this->warn('请先运行 [ php artisan install role ] 命令来初始化meedu的管理员权限数据');
            return CommandAlias::FAILURE;
        }

        $administrator = new Administrator([
            'name' => '超级管理员',
            'email' => 'meedu@meedu.meedu',
            'password' => Hash::make('meedu123'),
        ]);
        $administrator->save();
        $administrator->roles()->attach($super['id']);

        $this->info('管理员初始化成功');

        return CommandAlias::SUCCESS;
    }

    public function actionAdministrator()
    {
        $super = AdministratorRole::query()->where('slug', config('meedu.administrator.super_slug'))->first();
        if (!$super) {
            $this->warn('请先运行 [ php artisan install role ] 命令来初始化meedu的管理员权限数据');

            return CommandAlias::FAILURE;
        }

        // 是否静默安装
        if (!$this->option('q')) {
            $name = '超级管理员';
            $email = $this->ask('请输入邮箱(默认：meedu@meedu.meedu):', 'meedu@meedu.meedu');
            if (!$email) {
                $this->warn('邮箱不能空');

                return CommandAlias::FAILURE;
            }
            $emailExists = Administrator::query()->where('email', $email)->exists();
            if ($emailExists) {
                $this->warn('邮箱已经存在');

                return CommandAlias::FAILURE;
            }

            $password = '';
            while ($password === '') {
                $password = $this->ask('请输入密码(默认：meedu123):', 'meedu123');
            }

            $passwordRepeat = '';
            while ($passwordRepeat === '') {
                $passwordRepeat = $this->ask('请再输入一次(默认：meedu123):', 'meedu123');
            }

            if ($passwordRepeat !== $password) {
                $this->warn('两次输入密码不一致');

                return CommandAlias::FAILURE;
            }
        } else {
            $name = '超级管理员';
            $email = 'meedu@meedu.meedu';
            $password = 'meedu123';
        }

        $administrator = new Administrator([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        $administrator->save();
        $administrator->roles()->attach($super->id);

        $this->info('管理员初始化成功');

        return CommandAlias::SUCCESS;
    }

    // 系统权限生成
    public function actionRole()
    {
        $seeder = new class() extends Seeder {
        };
        $seeder->call(AdministratorSuperSeeder::class);
        $seeder->call(AdministratorPermissionSeeder::class);

        $this->info('数据初始化成功');

        return CommandAlias::SUCCESS;
    }

    public function actionConfig()
    {
        $seeder = new class() extends Seeder {
        };
        $seeder->call(AppConfigSeeder::class);

        $this->info('配置初始化完成');

        return CommandAlias::SUCCESS;
    }
}
