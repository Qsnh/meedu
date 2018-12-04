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

                // 配置写入.env文件
                $content = file_get_contents(base_path('.env'));
                $content = str_replace('APP_NAME=MeEdu', 'APP_NAME='.session('APP_NAME'), $content);
                $content = str_replace('APP_URL=http://localhost', 'APP_URL='.session('APP_URL'), $content);
                $content = str_replace('DB_HOST=127.0.0.1', 'DB_HOST='.$env['DB_HOST'], $content);
                $content = str_replace('DB_PORT=3306', 'DB_PORT='.$env['DB_PORT'], $content);
                $content = str_replace('DB_DATABASE=homestead', 'DB_DATABASE='.$env['DB_DATABASE'], $content);
                $content = str_replace('DB_USERNAME=homestead', 'DB_USERNAME='.$env['DB_USERNAME'], $content);
                $content = str_replace('DB_PASSWORD=secret', 'DB_PASSWORD='.$env['DB_PASSWORD'], $content);
                file_put_contents(base_path('.env'), $content);

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
            DB::beginTransaction();
            try {
                // 安装数据表
                $result = Artisan::call('migrate', [], $output);
                throw_if(! $result, new \Exception('数据表安装错误，错误信息：'.$output->fetch()));

                // 初始化角色
                $result = Artisan::call('install', ['action' => 'role'], $output);
                throw_if(! $result, new \Exception('管理员角色初始化失败，错误信息：'.$output->fetch()));

                // 初始化后台菜单
                $result = Artisan::call('install', ['action' => 'backend_menu'], $output);
                throw_if(! $result, new \Exception('后台菜单初始化失败，错误信息：'.$output->fetch()));

                // 初始化管理员
                $super = AdministratorRole::whereSlug(config('meedu.administrator.super_slug'))->first();
                $administrator = new Administrator([
                    'name' => '超级管理员',
                    'email' => $admin['username'],
                    'password' => bcrypt($admin['password']),
                ]);
                $administrator->save();
                $administrator->roles()->attach($super->id);

                DB::commit();

                return redirect()->route('install.step4');
            } catch (\Exception $exception) {
                DB::rollBack();

                return redirect()->back()->withErrors($exception->getMessage());
            }
        }

        return view('install.step3');
    }

    public function step4(Request $request)
    {
        $output = new BufferedOutput();
        try {
            // 软链接
            $result = Artisan::call('storage:link', [], $output);
            throw_if(! $result, new \Exception($output->fetch()));

            flash('安装成功');

            file_put_contents(base_path('storage/install.lock'), time());

            return redirect(route('backend.login'));
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
}
