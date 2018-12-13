<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Install;

use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Connectors\MySqlConnector;
use Symfony\Component\Console\Output\BufferedOutput;

class InstallController extends Controller
{
    public function step1(Request $request)
    {
        if ($request->isMethod('POST')) {
            session([
                'APP_NAME' => $request->post('APP_NAME', 'MeEdu'),
                'APP_URL' => $request->post('APP_URL', 'http://127.0.0.1'),
            ]);

            return redirect()->route('install.step2');
        }

        return view('install.step1');
    }

    public function step2(Request $request)
    {
        if ($request->isMethod('POST')) {
            $env = $request->validate([
                'DB_HOST' => 'required',
                'DB_DATABASE' => 'required',
                'DB_USERNAME' => 'required',
                'DB_PASSWORD' => 'required',
                'DB_PORT' => 'required',
            ], [
                'DB_HOST.required' => '请输入数据库连接地址',
                'DB_DATABASE.required' => '请输入数据库名',
                'DB_USERNAME.required' => '请输入数据库用户名',
                'DB_PASSWORD.required' => '请输入数据库密码',
                'DB_PORT.required' => '请输入数据库端口号',
            ]);
            // 测试数据库连接
            $mysql = [
                'host' => $env['DB_HOST'],
                'port' => $env['DB_PORT'],
                'database' => $env['DB_DATABASE'],
                'username' => $env['DB_USERNAME'],
                'password' => $env['DB_PASSWORD'],
            ];
            try {
                (new MySqlConnector())->connect($mysql);

                $env['APP_NAME'] = session('APP_NAME');
                $env['APP_URL'] = session('APP_URL');
                // 配置文件写入
                env_update($env);

                return redirect()->route('install.step3');
            } catch (\Exception $exception) {
                return redirect()->back()->withErrors('错误信息：'.$exception->getMessage());
            }
        }

        return view('install.step2');
    }

    public function step3(Request $request)
    {
        if ($request->isMethod('POST')) {
            $admin = $request->validate([
                'username' => 'required|email',
                'password' => 'required',
            ], [
                'username.required' => '请输入邮箱',
                'username.email' => '请输入邮箱',
                'password.required' => '请输入密码',
            ]);

            $output = new BufferedOutput();
            $log = [];
            DB::beginTransaction();
            try {
                // 安装数据表
                Artisan::call('migrate', [], $output);
                $log[] = $output->fetch();

                // 初始化角色
                Artisan::call('install', ['action' => 'role'], $output);
                $log[] = $output->fetch();

                // 初始化后台菜单
                Artisan::call('install', ['action' => 'backend_menu'], $output);
                $log[] = $output->fetch();

                // Password keys
                Artisan::call('passport:keys', [], $output);
                $log[] = $output->fetch();

                // 初始化管理员
                $super = AdministratorRole::whereSlug(config('meedu.administrator.super_slug'))->first();
                if (! Administrator::whereEmail($admin['username'])->exists()) {
                    $administrator = new Administrator([
                        'name' => '超级管理员',
                        'email' => $admin['username'],
                        'password' => bcrypt($admin['password']),
                    ]);
                    $administrator->save();
                    $administrator->roles()->attach($super->id);
                }

                // 软链接
                app()->make('files')->link(storage_path('app/public'), public_path('storage'));

                // KEY
                Artisan::call('key:generate', [], $output);
                $log[] = $output->fetch();

                // 安装锁
                app()->make('files')->put(storage_path('install.lock'), time());

                DB::commit();

                flash('安装成功', 'success');

                // 记录安装日志
                Log::info($log);

                return redirect('/');
            } catch (\Exception $exception) {
                DB::rollBack();

                return redirect()->back()->withErrors($exception->getMessage());
            }
        }

        return view('install.step3');
    }
}
