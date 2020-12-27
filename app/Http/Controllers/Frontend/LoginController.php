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

use App\Bus\AuthBus;
use App\Meedu\Wechat;
use Illuminate\Http\Request;
use App\Constant\FrontendConstant;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Member\Services\SocialiteService;
use App\Http\Requests\Frontend\LoginPasswordRequest;
use App\Services\Base\Interfaces\ConfigServiceInterface;
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

    public function passwordLoginHandler(LoginPasswordRequest $request, AuthBus $bus)
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

        $bus->webLogin(
            $user['id'],
            $request->has('remember'),
            is_h5() ? FrontendConstant::LOGIN_PLATFORM_H5 : FrontendConstant::LOGIN_PLATFORM_PC
        );

        return redirect($bus->redirectTo());
    }

    public function socialLogin(Request $request, AuthBus $bus, $app)
    {
        // 登录后的跳转地址
        $redirect = $request->input('redirect');
        $redirect && $bus->recordSocialiteRedirectTo($redirect);

        // 指定token登录
        $bus->recordSocialiteTokenWay();

        // 指定登录的平台[pc,h5,android,ios等]
        $bus->recordSocialitePlatform();

        return Socialite::driver($app)->redirect();
    }

    public function socialiteLoginCallback(AuthBus $bus, $app)
    {
        if ($app === 'wechat') {
            // 微信公众号授权登录
            $user = Wechat::getInstance()->oauth->user();
            $appId = $user->getId();
            $user = [
                'id' => $user->getId(),
                'nickname' => $user->getNickname(),
                'avatar' => $user->getAvatar(),
            ];
        } else {
            // 其它社交登录
            $user = Socialite::driver($app)->user();
            $appId = $user->getId();
        }

        // 已登录的情况下，执行社交账号的绑定操作
        if ($this->check()) {
            // 经过测试，已登录下访问绑定的url将会陷入重定向死循环
            // 所以这里捕获异常做单独处理
            try {
                $this->socialiteService->bindApp($this->id(), $app, $appId, (array)$user);
                flash(__('socialite bind success'), 'success');
                return redirect('member');
            } catch (ServiceException $e) {
                flash($e->getMessage());
                return redirect(route('member'));
            } catch (\Exception $e) {
                abort(500);
            }
        }

        // 读取当前社交账号绑定的用户id
        $userId = $this->socialiteService->getBindUserId($app, $appId);
        // 当前社交账号已经绑定了用户id可以直接登录
        if ($userId) {
            // 用户是否锁定检测
            $user = $this->userService->find($userId);
            if ($user['is_lock'] === FrontendConstant::YES) {
                flash(__('current user was locked,please contact administrator'));
                return redirect(url('/?skip_wechat=1'));
            }
            return redirect($bus->socialiteRedirectTo($bus->socialiteLogin($userId)));
        }

        // 接下来，当前社交账号是一个全新的账号
        // 如果系统开启了强制绑定手机号的操作，则进入手机号绑定的流程
        // 如果系统未开启手机号绑定，则直接创建匿名手机号新用户，然后直接登录

        /**
         * @var ConfigService $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);
        $mustBindMobileStatus = $configService->getEnabledMobileBindAlert();

        if (!$mustBindMobileStatus) {
            // 未开启手机号的强制绑定
            $userId = $this->socialiteService->bindAppWithNewUser($app, $appId, (array)$user);
            return redirect($bus->socialiteRedirectTo($bus->socialiteLogin($userId)));
        }

        // 缓存当前的社交登录用户信息
        // 跳转到强制绑定手机号的界面
        // 需要配置中间件做检测
        session([FrontendConstant::SOCIALITE_USER_INFO_KEY => [
            'app' => $app,
            'app_id' => $appId,
            'user' => (array)$user,
        ]]);

        return redirect(route('member.mobile.bind'));
    }

    public function logout()
    {
        Auth::logout();
        flash(__('success'), 'success');
        return redirect(url('/'));
    }
}
