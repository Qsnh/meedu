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
use Illuminate\Http\Request;
use App\Events\UserLoginEvent;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Services\Member\Services\UserService;
use App\Services\Member\Services\SocialiteService;
use App\Http\Requests\Frontend\LoginPasswordRequest;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;

class LoginController extends BaseController
{

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var SocialiteService
     */
    protected $socialiteService;

    public function __construct(UserServiceInterface $userService, SocialiteServiceInterface $socialiteService)
    {
        $this->userService = $userService;
        $this->socialiteService = $socialiteService;
        $this->middleware('guest')->except(
            'logout',
            'socialLogin',
            'socialiteLoginCallback'
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginPage(Request $request)
    {
        // 主动配置redirect
        $redirect = $request->input('redirect');

        if (!$redirect && $redirect = request()->server('HTTP_REFERER')) {
            // 当为配置redirect的时候，检测http_referer
            foreach (FrontendConstant::LOGIN_REFERER_BLACKLIST as $item) {
                if (preg_match("#{$item}#ius", $redirect)) {
                    $redirect = '';
                    break;
                }
            }
        }

        // 存储redirectTo
        $redirect && session([FrontendConstant::LOGIN_CALLBACK_URL_KEY => $redirect]);

        $title = __('title.login');

        return v('frontend.auth.login', compact('title'));
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
        if ($user['is_lock'] == FrontendConstant::YES) {
            flash(__('current user was locked,please contact administrator'));
            return back();
        }
        Auth::loginUsingId($user['id'], $request->has('remember'));

        event(new UserLoginEvent($user['id'], is_h5() ? FrontendConstant::LOGIN_PLATFORM_H5 : FrontendConstant::LOGIN_PLATFORM_PC));

        return redirect($this->redirectTo());
    }

    /**
     * 社交登录
     *
     * @param Request $request
     * @param string $app
     */
    public function socialLogin(Request $request, $app)
    {
        $redirect = $request->input('redirect');
        $redirect && session(['socialite_login_redirect' => $redirect]);

        // 开始跳转
        return Socialite::driver($app)->redirect();
    }

    public function socialiteLoginCallback(Request $request, $app)
    {
        $user = Socialite::driver($app)->user();
        $appId = $user->getId();
        if (Auth::check()) {
            $this->socialiteService->bindApp(Auth::id(), $app, $appId, (array)$user);
            flash(__('socialite bind success'), 'success');
            return redirect('member');
        }
        $userId = $this->socialiteService->getBindUserId($app, $appId);
        if (!$userId) {
            $userId = $this->socialiteService->bindAppWithNewUser($app, $appId, (array)$user);
        }

        // 用户是否锁定检测
        $user = $this->userService->find($userId);
        if ($user['is_lock'] === FrontendConstant::YES) {
            flash(__('current user was locked,please contact administrator'));
            return back();
        }

        // 登录该用户
        Auth::loginUsingId($userId, true);

        // 登录事件
        event(new UserLoginEvent($userId, is_h5() ? FrontendConstant::LOGIN_PLATFORM_H5 : FrontendConstant::LOGIN_PLATFORM_PC));

        if ($redirect = session('socialite_login_redirect')) {
            $token = Auth::guard(FrontendConstant::API_GUARD)->tokenById($userId);
            $redirect .= (strpos($redirect, '?') === false ? '?' : '&') . 'token=' . $token;
            return redirect($redirect);
        }

        return redirect($this->redirectTo());
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

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed|string
     */
    protected function redirectTo()
    {
        $redirectTo = session(FrontendConstant::LOGIN_CALLBACK_URL_KEY);
        $redirectTo = $redirectTo ?: route('index');
        return $redirectTo;
    }
}
