<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use App\Models\Administrator;
use App\Models\AdministratorLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Backend\LoginRequest;

class LoginController extends BaseController
{
    const GUARD = 'administrator';

    public function login(LoginRequest $request)
    {
        if (captcha_image_check() === false) {
            return $this->error(__('图形验证码错误'));
        }

        ['username' => $username, 'password' => $password] = $request->filldata();

        $admin = Administrator::query()->where('email', $username)->first();
        if (!$admin) {
            return $this->error(__('邮箱不存在'));
        }
        if (!Hash::check($password, $admin->password)) {
            return $this->error(__('密码错误'));
        }

        if ($admin->is_ban_login === 1) {
            return $this->error(__('当前管理员已被锁定无法登录'));
        }

        // jwt登录
        $token = Auth::guard(self::GUARD)->login($admin);

        // 登录日志
        $admin->last_login_ip = $request->getClientIp();
        $admin->last_login_date = Carbon::now();
        $admin->login_times++;
        $admin->save();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_LOGIN,
            AdministratorLog::OPT_LOGIN,
            compact('username')
        );

        return $this->successData(compact('token'));
    }

    public function user()
    {
        $admin = Auth::guard(self::GUARD)->user();

        $permissions = $admin->permissions();
        $admin['permissions'] = $permissions;

        return $this->successData($admin);
    }

    public function logout()
    {
        $admin = Auth::guard(self::GUARD)->user();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_LOGIN,
            AdministratorLog::OPT_LOGOUT,
            ['email' => $admin['email'], 'id' => $admin['id']]
        );

        Auth::guard(self::GUARD)->logout();

        return $this->success();
    }
}
