<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Bus\AuthBus;
use Illuminate\Http\Request;
use App\Events\UserLogoutEvent;
use App\Constant\FrontendConstant;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Base\Services\CacheService;
use App\Services\Member\Services\UserService;
use App\Http\Requests\ApiV2\MobileLoginRequest;
use App\Http\Requests\ApiV2\PasswordLoginRequest;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;

class LoginController extends BaseController
{
    /**
     * @var UserService
     */
    protected $userService;

    protected $configService;

    /**
     * @var CacheService
     */
    protected $cacheService;

    protected $socialiteService;

    public function __construct(
        UserServiceInterface      $userService,
        ConfigServiceInterface    $configService,
        CacheServiceInterface     $cacheService,
        SocialiteServiceInterface $socialiteService
    ) {
        $this->userService = $userService;
        $this->configService = $configService;
        $this->cacheService = $cacheService;
        $this->socialiteService = $socialiteService;
    }

    /**
     * @api {post} /api/v2/login/password [V2]登录-密码登录
     * @apiGroup 用户认证
     * @apiName LoginPassword
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} password 密码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.token token
     */
    public function passwordLogin(PasswordLoginRequest $request)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();
        $user = $this->userService->passwordLogin($mobile, $password);
        if (!$user) {
            return $this->error(__('手机号或密码错误'));
        }

        try {
            $token = $this->token($user);

            return $this->data(compact('token'));
        } catch (ServiceException $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @api {post} /api/v2/login/mobile [V2]登录-短信登录
     * @apiGroup 用户认证
     * @apiName LoginMobile
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} mobile_code 短信验证码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.token token
     */
    public function mobileLogin(MobileLoginRequest $request)
    {
        $this->mobileCodeCheck();

        ['mobile' => $mobile] = $request->filldata();

        $user = $this->userService->findMobile($mobile);
        if (!$user) {
            // 直接注册
            $user = $this->userService->createWithMobile($mobile, '', '');
        }

        try {
            $token = $this->token($user);

            return $this->data(compact('token'));
        } catch (ServiceException $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @param $user
     * @return mixed
     * @throws ServiceException
     */
    private function token($user)
    {
        if ((int)$user['is_lock'] === 1) {
            throw new ServiceException(__('账号已被锁定'));
        }

        /**
         * @var AuthBus $authBus
         */
        $authBus = app()->make(AuthBus::class);

        return $authBus->tokenLogin($user['id'], get_platform());
    }

    /**
     * @api {get} /api/v2/login/socialite/qq [V2]登录-QQ登录
     * @apiGroup 用户认证
     * @apiName LoginSocialites
     * @apiDescription 登录成功之后会在success_redirect中携带token返回
     *
     * @apiParam {String} success_redirect 成功之后的跳转URL(需要urlEncode)
     * @apiParam {String} failed_redirect 失败之后跳转的URL(需要urlEncode)
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function socialiteLogin(Request $request, ConfigServiceInterface $configService, $app)
    {
        $successRedirect = $request->input('success_redirect');
        $failedRedirect = $request->input('failed_redirect');

        if (!$successRedirect || !$failedRedirect) {
            return $this->error(__('参数错误'));
        }

        $enabledSocialites = $configService->getEnabledSocialiteApps();
        if (!in_array($app, array_column($enabledSocialites, 'app'))) {
            return $this->error(__('参数错误'));
        }

        $redirectUrl = route('api.v2.login.socialite.callback', [$app]);
        $redirectUrl = url_append_query($redirectUrl, [
            's_url' => urlencode($successRedirect),
            'f_url' => urlencode($failedRedirect),
        ]);

        return Socialite::driver($app)
            ->redirectUrl($redirectUrl)
            ->stateless()
            ->redirect();
    }

    // 社交登录回调
    public function socialiteLoginCallback(Request $request, $app)
    {
        $successRedirectUrl = urldecode($request->input('s_url'));
        $failedRedirectUrl = urldecode($request->input('f_url'));

        // 再次构建社交登录的回调URL
        // 部分社交应用会重复检查回调的URL，不一致将会导致授权失败
        // 再获取用户信息的时候依旧需要指定一致的URL
        $redirectUrl = route('api.v2.login.socialite.callback', [$app]);
        $user = Socialite::driver($app)->redirectUrl($redirectUrl)->stateless()->user();

        $appId = $user->getId();

        $userId = $this->socialiteService->getBindUserId($app, $appId);

        if (!$userId) {
            $userId = $this->socialiteService->bindAppWithNewUser($app, $appId, (array)$user);
        }

        // 用户是否锁定检测
        $user = $this->userService->find($userId);

        try {
            $token = $this->token($user);

            return redirect(url_append_query($successRedirectUrl, ['token' => $token]));
        } catch (ServiceException $e) {
            return redirect(url_append_query($failedRedirectUrl, ['msg' => $e->getMessage()]));
        }
    }

    /**
     * @api {post} /api/v2/logout [V2]安全退出
     * @apiGroup 用户认证
     * @apiName LoginLogout
     *
     * @apiSuccess {Number} code 0成功,非0失败
     */
    public function logout(Request $request)
    {
        $userId = Auth::guard(FrontendConstant::API_GUARD)->id();
        $token = explode(' ', $request->header('Authorization'))[1];
        event(new UserLogoutEvent($userId, $token));

        Auth::guard(FrontendConstant::API_GUARD)->logout();

        return $this->success();
    }
}
