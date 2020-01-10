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

use Socialite;
use App\Events\UserLoginEvent;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Services\Member\Services\UserService;
use App\Http\Requests\Frontend\LoginPasswordRequest;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;

class LoginController extends BaseController
{

    /**
     * @var UserService
     */
    protected $userService;

    protected $socialiteService;

    public function __construct(UserServiceInterface $userService, SocialiteServiceInterface $socialiteService)
    {
        $this->userService = $userService;
        $this->socialiteService = $socialiteService;
        $this->middleware('guest')->except(
            'logout',
            'showLoginPage',
            'passwordLoginHandler',
            'socialLogin',
            'socialiteLoginCallback'
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginPage()
    {
        return v('frontend.auth.login');
    }

    /**
     * @param LoginPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function passwordLoginHandler(LoginPasswordRequest $request)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();
        $user = $this->userService->passwordLogin($mobile, $password);
        if (!$user) {
            flash(__('mobile not exists or password error'), 'error');
            return back();
        }
        Auth::loginUsingId($user['id'], $request->has('remember'));

        event(new UserLoginEvent($user['id']));

        return redirect(url('/'));
    }

    /**
     * 社交登录
     * @param $app
     * @return mixed
     */
    public function socialLogin($app)
    {
        return Socialite::driver($app)->redirect();
    }

    /**
     * @param $app
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function socialiteLoginCallback($app)
    {
        $user = Socialite::driver($app)->user();
        $appId = $user->getId();
        if (Auth::check()) {
            $this->socialiteService->bindApp(Auth::id(), $app, $appId, $user);
            flash(__('socialite bind success'), 'success');
            return redirect('member');
        }
        if ($bindUserId = $this->socialiteService->getBindUserId($app, $appId)) {
            Auth::loginUsingId($bindUserId);
            return redirect(url('/'));
        }
        $userId = $this->socialiteService->bindAppWithNewUser($app, $appId, $user);
        Auth::loginUsingId($userId, true);
        return redirect(url('/'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        flash(__('success'), 'success');
        return redirect(url('/'));
    }
}
