<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Services\Member\Services\UserService;
use App\Http\Requests\Frontend\RegisterPasswordRequest;
use App\Services\Member\Interfaces\UserServiceInterface;

class RegisterController extends BaseController
{

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        parent::__construct();

        $this->userService = $userService;
        $this->middleware('guest');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegisterPage()
    {
        $title = __('注册');

        return v('frontend.auth.register', compact('title'));
    }

    /**
     * @param RegisterPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function passwordRegisterHandler(RegisterPasswordRequest $request)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();

        $user = $this->userService->findMobile($mobile);

        if ($user) {
            flash(__('手机号已存在'));
            return back();
        }

        $this->userService->createWithMobile($mobile, $password, '');

        flash(__('成功'), 'success');

        return redirect(route('login'));
    }
}
