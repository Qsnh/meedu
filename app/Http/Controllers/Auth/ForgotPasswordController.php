<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PasswordResetRequest;

class ForgotPasswordController extends Controller
{
    public function showPage()
    {
        return view('auth.passwords.find');
    }

    public function handler(PasswordResetRequest $request)
    {
        $user = User::whereMobile($request->post('mobile'))->first();
        if (! $user) {
            flash('用户不存在');

            return back();
        }

        $user->password = bcrypt($request->post('password'));
        $user->save();

        flash('密码修改成功', 'success');

        return redirect(route('login'));
    }
}
