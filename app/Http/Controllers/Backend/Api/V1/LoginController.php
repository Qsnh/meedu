<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use App\Models\Administrator;
use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Backend\LoginRequest;

class LoginController extends BaseController
{
    const GUARD = 'administrator';

    public function login(LoginRequest $request)
    {
        ['username' => $username, 'password' => $password] = $request->filldata();
        $admin = Administrator::whereEmail($username)->first();
        if (!$admin) {
            return $this->error(BackendApiConstant::ADMINISTRATOR_NOT_EXISTS);
        }
        if (!Hash::check($password, $admin->password)) {
            return $this->error(BackendApiConstant::LOGIN_PASSWORD_ERROR);
        }
        // jwt登录
        $token = Auth::guard(self::GUARD)->login($admin);

        // 登录日志
        $admin->last_login_ip = $request->getClientIp();
        $admin->last_login_date = Carbon::now();
        $admin->save();

        return $this->successData(compact('token'));
    }

    public function user()
    {
        $admin = Auth::guard(self::GUARD)->user();

        return $this->successData($admin);
    }
}
