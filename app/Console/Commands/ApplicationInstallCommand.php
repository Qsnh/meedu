<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Console\Commands;

use App\Models\Administrator;
use Illuminate\Console\Command;
use Illuminate\Database\Seeder;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class ApplicationInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install {action} {--q}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Application install tools.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        if (!$action) {
            $this->warn('Please choice action.');

            return;
        }

        $method = 'action' . implode('', array_map('ucfirst', explode('_', $action)));
        if (!method_exists($this, $method)) {
            $this->warn('action not exists.');

            return;
        }

        return $this->{$method}();
    }

    public function actionAdministrator()
    {
        $super = AdministratorRole::whereSlug(config('meedu.administrator.super_slug'))->first();
        if (!$super) {
            $this->warn('请先运行 [ php artisan install role ] 命令来初始化meedu的管理员权限数据。');

            return;
        }

        // 是否静默安装
        if (!$this->option('q')) {
            $name = '超级管理员';
            $email = $this->ask('请输入邮箱(默认：meedu@meedu.meedu):', 'meedu@meedu.meedu');
            if (!$email) {
                $this->warn('邮箱不能空');

                return;
            }
            $emailExists = Administrator::whereEmail($email)->exists();
            if ($emailExists) {
                $this->warn('邮箱已经存在');

                return;
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
                $this->warn('两次输入密码不一致.');

                return;
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

        $this->info('管理员初始化成功.');
    }

    public function actionDev()
    {
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    // 系统权限生成
    public function actionRole()
    {
        $seeder = new class() extends Seeder {
        };
        $seeder->call(\AdministratorSuperSeeder::class);
        $seeder->call(\AdministratorPermissionSeeder::class);
        $seeder->call(\AdministratorMenuSeeder::class);

        $this->info('数据初始化成功');
    }

    public function actionConfig()
    {
        $seeder = new class() extends Seeder {
        };
        $seeder->call(\AppConfigSeeder::class);

        $this->info('配置初始化完成');
    }
}
