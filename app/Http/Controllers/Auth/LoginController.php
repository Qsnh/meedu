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

use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Member\Services\SocialiteService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/member';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except(
            'logout',
            'redirectToProvider',
            'handleProviderCallback'
        );
    }

    /**
     * @override
     *
     * @return string
     */
    protected function username()
    {
        return 'mobile';
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($app)
    {
        return Socialite::driver($app)->redirect();
    }

    /**
     * @param SocialiteService $socialiteService
     * @param $app
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @throws \App\Exceptions\ServiceException
     */
    public function handleProviderCallback(SocialiteService $socialiteService, $app)
    {
        $user = Socialite::driver($app)->user();
        $appId = $user->getId();

        if (Auth::check()) {
            $socialiteService->bindApp(Auth::id(), $app, $appId, $user);
            flash(__('socialite bind success'), 'success');

            return redirect('member');
        }

        if ($bindUserId = $socialiteService->getBindUserId($app, $appId)) {
            Auth::loginUsingId($bindUserId);
            flash('login success', 'success');

            return redirect($this->redirectPath());
        }

        $userId = $socialiteService->bindAppWithNewUser($app, $appId, $user);
        Auth::loginUsingId($userId, true);
        flash('login success', 'success');

        return redirect($this->redirectPath());
    }
}
