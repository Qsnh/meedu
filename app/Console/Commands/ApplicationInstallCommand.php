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
use Illuminate\Support\Facades\Artisan;

class ApplicationInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install {action}';

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
        if (! $action) {
            $this->warn('Please choice action.');

            return;
        }

        $method = 'action'.implode('', array_map('ucfirst', explode('_', $action)));
        if (! method_exists($this, $method)) {
            $this->warn('action not exists.');

            return;
        }

        return $this->{$method}();
    }

    public function actionAdministrator()
    {
        $name = '超级管理员';
        $email = '';
        while ($email == '') {
            $email = $this->ask('please input administrator email:', '');
            if ($email != '') {
                $exists = Administrator::whereEmail($email)->exists();
                if ($exists) {
                    $this->warn('email has already exists.');
                    $email = '';
                }
            }
        }

        $password = '';
        while ($password == '') {
            $password = $this->ask('please input administrator password:', '');
        }

        $passwordRepeat = '';
        while ($passwordRepeat == '') {
            $passwordRepeat = $this->ask('please input administrator password repeat:', '');
        }

        if ($passwordRepeat != $password) {
            $this->warn('password not correct.');

            return;
        }

        $administrator = new Administrator([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        $administrator->save();

        $this->info('administrator create success.');
    }

    public function actionDev()
    {
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

}
