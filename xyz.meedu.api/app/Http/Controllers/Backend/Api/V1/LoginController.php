<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use App\Models\Administrator;
use App\Meedu\SystemSetupLock;
use App\Models\AdministratorLog;
use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Backend\LoginRequest;

class LoginController extends BaseController
{
    public function login(LoginRequest $request)
    {
        if (captcha_image_check() === false) {
            return $this->error(__('图形验证码错误'));
        }

        ['username' => $username, 'password' => $password] = $request->filldata();

        $admin = Administrator::query()->where('email', $username)->first();
        if (!$admin || !Hash::check($password, $admin['password'])) {
            return $this->error(__('邮箱或密码错误'));
        }

        if (1 === $admin['is_ban_login']) {
            return $this->error(__('当前管理员已被锁定无法登录'));
        }

        $token = Auth::guard(BackendApiConstant::GUARD)->login($admin);

        $admin['last_login_ip'] = $request->getClientIp();
        $admin['last_login_date'] = Carbon::now();
        $admin['login_times'] = $admin['login_times'] + 1;
        $admin->save();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_LOGIN,
            AdministratorLog::OPT_LOGIN,
            compact('username')
        );

        // 老站点自愈:升级到 4.9.32+ 但未补写 setup.lock 的站点,
        // 在任意管理员成功登录时一次性补写,让公开 /system/setup 接口立即关闭。
        if (!SystemSetupLock::exists()) {
            SystemSetupLock::write([
                'source' => SystemSetupLock::SOURCE_LOGIN_HEAL,
                'admin_id' => $admin['id'],
                'email' => $admin['email'],
                'ip' => $request->getClientIp(),
            ]);
        }

        return $this->successData(compact('token'));
    }

    public function user()
    {
        $admin = Auth::guard(BackendApiConstant::GUARD)->user();

        $permissions = $admin->permissions();
        $admin['permissions'] = $permissions;

        return $this->successData($admin);
    }

    public function logout()
    {
        $admin = Auth::guard(BackendApiConstant::GUARD)->user();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_LOGIN,
            AdministratorLog::OPT_LOGOUT,
            ['id' => $admin['id']]
        );

        Auth::guard(BackendApiConstant::GUARD)->logout();

        return $this->success();
    }
}
