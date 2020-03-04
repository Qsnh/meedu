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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginPage()
    {
        $previousUrl = request()->server('HTTP_REFERER') ?: url('/');
        foreach (FrontendConstant::LOGIN_REFERER_BLACKLIST as $item) {
            if (preg_match("#{$item}#ius", $previousUrl)) {
                $previousUrl = url('/');
                break;
            }
        }
        session([FrontendConstant::LOGIN_CALLBACK_URL_KEY => $previousUrl]);
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
        if ($user['is_lock'] == FrontendConstant::YES) {
            flash(__('current user was locked,please contact administrator'));
            return back();
        }
        Auth::loginUsingId($user['id'], $request->has('remember'));

        event(new UserLoginEvent($user['id']));

        return redirect($this->redirectTo());
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
     * @throws \App\Exceptions\ServiceException
     */
    public function socialiteLoginCallback($app)
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
        event(new UserLoginEvent($userId));

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
     * @return \Illuminate\Contracts\Routing\UrlGenerator|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed|string
     */
    protected function redirectTo()
    {
        $callbackUrl = session()->has(FrontendConstant::LOGIN_CALLBACK_URL_KEY) ?
            session(FrontendConstant::LOGIN_CALLBACK_URL_KEY) : url('/');
        return $callbackUrl;
    }
}
