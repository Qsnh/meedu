<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Member\Services\UserService;
use App\Http\Requests\Frontend\PasswordResetRequest;
use App\Services\Member\Interfaces\UserServiceInterface;

class ForgotPasswordController extends Controller
{

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest');
    }

    public function showPage()
    {
        $title = __('title.find_password');
        return v('frontend.auth.passwords.find', compact('title'));
    }

    public function handler(PasswordResetRequest $request)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();

        $this->userService->findPassword($mobile, $password);

        flash(__('password change success'), 'success');

        return redirect(route('login'));
    }
}
