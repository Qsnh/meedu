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

use App\Http\Controllers\Controller;
use App\Services\Member\Services\UserService;
use App\Http\Requests\Frontend\PasswordResetRequest;

class ForgotPasswordController extends Controller
{
    public function showPage()
    {
        return v('auth.passwords.find');
    }

    public function handler(PasswordResetRequest $request, UserService $userService)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();

        $userService->findPassword($mobile, $password);

        flash(__('password change success'), 'success');

        return redirect(route('login'));
    }
}
