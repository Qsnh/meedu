<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Bus\AuthBus;
use App\Meedu\Wechat;
use App\Meedu\WechatMini;
use Illuminate\Http\Request;
use App\Constant\CacheConstant;
use App\Exceptions\ServiceException;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Http\Requests\ApiV2\MobileLoginRequest;
use App\Http\Requests\ApiV2\PasswordLoginRequest;
use App\Services\Member\Services\SocialiteService;
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

    /**
     * @var ConfigService
     */
    protected $configService;

    /**
     * @var CacheService
     */
    protected $cacheService;

    /**
     * @var SocialiteService
     */
    protected $socialiteService;

    /**
     * LoginController constructor.
     * @param UserServiceInterface $userService
     * @param ConfigServiceInterface $configService
     * @param CacheServiceInterface $cacheService
     * @param SocialiteServiceInterface $socialiteService
     */
    public function __construct(
        UserServiceInterface $userService,
        ConfigServiceInterface $configService,
        CacheServiceInterface $cacheService,
        SocialiteServiceInterface $socialiteService
    )
    {
        $this->userService = $userService;
        $this->configService = $configService;
        $this->cacheService = $cacheService;
        $this->socialiteService = $socialiteService;
    }

    /**
     * @api {post} /api/v2/login/password 密码登录
     * @apiGroup Auth
     * @apiVersion v2.0.0
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
     * @api {post} /api/v2/login/mobile 短信登录
     * @apiGroup Auth
     * @apiVersion v2.0.0
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
     * @api {post} /api/v2/login/wechatMiniMobile 微信小程序手机号登录
     * @apiGroup Auth
     * @apiVersion v2.0.0
     *
     * @apiParam {String} openid openid
     * @apiParam {String} iv iv
     * @apiParam {String} encryptedData encryptedData
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.token token
     */
    public function wechatMiniMobile(Request $request, AuthBus $authBus)
    {
        $openid = $request->input('openid');
        $encryptedData = $request->input('encryptedData');
        $iv = $request->input('iv');
        $userInfo = $request->input('userInfo');

        if (
            !$openid || !$encryptedData || !$iv ||
            !$userInfo ||
            !($userInfo['encryptedData'] ?? '') ||
            !($userInfo['iv'] ?? '') ||
            !($userInfo['rawData'] ?? '') ||
            !($userInfo['signature'] ?? '')
        ) {
            return $this->error(__('错误'));
        }

        $sessionKey = $this->cacheService->get(get_cache_key(CacheConstant::WECHAT_MINI_SESSION_KEY['name'], $openid));
        if (!$sessionKey) {
            return $this->error(__('错误'));
        }

        // 校验签名
        if (sha1($userInfo['rawData'] . $sessionKey) !== $userInfo['signature']) {
            return $this->error(__('参数错误'));
        }

        $mini = WechatMini::getInstance();

        // 解密获取手机号
        $data = $mini->encryptor->decryptData($sessionKey, $iv, $encryptedData);
        $mobile = $data['phoneNumber'];
        // 解密获取用户信息
        $userData = $mini->encryptor->decryptData($sessionKey, $userInfo['iv'], $userInfo['encryptedData']);

        if ($openid !== $userData['openId']) {
            return $this->error(__('错误'));
        }

        // unionId
        $unionId = $userData['unionId'] ?? '';

        $user = $authBus->wechatMiniMobileLogin($openid, $unionId, $mobile, $userData);

        try {
            $token = $this->token($user);

            return $this->data(compact('token'));
        } catch (ServiceException $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @api {post} /api/v2/login/wechatMini 微信小程序静默授权登录
     * @apiGroup Auth
     * @apiVersion v2.0.0
     *
     * @apiParam {String} openid openid
     * @apiParam {String} iv iv
     * @apiParam {String} encryptedData encryptedData
     * @apiParam {String} rawData rawData
     * @apiParam {String} signature signature
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.token token
     */
    public function wechatMini(Request $request, AuthBus $authBus)
    {
        $openid = $request->input('openid');
        $raw = $request->input('rawData');
        $signature = $request->input('signature');
        $encryptedData = $request->input('encryptedData');
        $iv = $request->input('iv');

        if (
            !$openid ||
            !$raw ||
            !$signature ||
            !$encryptedData ||
            !$iv
        ) {
            return $this->error(__('错误'));
        }

        $sessionKey = $this->cacheService->get(get_cache_key(CacheConstant::WECHAT_MINI_SESSION_KEY['name'], $openid));
        if (!$sessionKey) {
            return $this->error(__('错误'));
        }

        // 验签
        if (sha1($raw . $sessionKey) !== $signature) {
            return $this->error(__('错误'));
        }

        // 解密获取用户信息
        $userData = WechatMini::getInstance()->encryptor->decryptData($sessionKey, $iv, $encryptedData);

        if ($openid !== $userData['openId']) {
            return $this->error(__('错误'));
        }

        // unionId
        $unionId = $userData['unionId'] ?? '';

        $userId = $authBus->wechatMiniLogin($openid, $unionId);
        if (!$userId) {
            return $this->error(__('错误'));
        }

        $user = $this->userService->find($userId);
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
    protected function token($user)
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
     * @api {get} /api/v2/login/wechat/oauth 微信公众号授权登录[重定向]
     * @apiGroup Auth
     * @apiVersion v2.0.0
     * @apiDescription 登录成功之后会在success_redirect中携带token返回
     *
     * @apiParam {String} success_redirect 成功之后的跳转URL(需要urlencode)
     * @apiParam {String} failed_redirect 失败之后跳转的URL(需要urlencode)
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function wechatLogin(Request $request)
    {
        $successRedirect = $request->input('success_redirect');
        $failedRedirect = $request->input('failed_redirect');

        if (!$successRedirect || !$failedRedirect) {
            return $this->error(__('参数错误'));
        }

        $redirectUrl = route('api.v2.login.wechat.callback');
        $redirectUrl = url_append_query($redirectUrl, ['s_url' => urlencode($successRedirect), 'f_url' => urlencode($failedRedirect)]);

        return Wechat::getInstance()->oauth->redirect($redirectUrl);
    }

    // 微信公众号授权登录[回调]
    public function wechatLoginCallback(Request $request, AuthBus $authBus)
    {
        $successRedirectUrl = urldecode($request->input('s_url', ''));
        $failedRedirectUrl = urldecode($request->input('f_url'));

        $user = Wechat::getInstance()->oauth->user();

        if (!$user) {
            return redirect(url_append_query($failedRedirectUrl, ['msg' => __('错误')]));
        }

        $originalData = $user['original'];

        $openid = $originalData['openid'];
        $unionId = $originalData['unionid'] ?? '';

        $userId = $authBus->wechatLogin($openid, $unionId, $originalData);

        $user = $this->userService->find($userId);

        try {
            $token = $this->token($user);

            return redirect(url_append_query($successRedirectUrl, ['token' => $token]));
        } catch (ServiceException $e) {
            return redirect(url_append_query($failedRedirectUrl, ['msg' => $e->getMessage()]));
        }
    }

    /**
     * @api {get} /api/v2/login/socialite/{app} 社交APP登录[重定向]
     * @apiGroup Auth
     * @apiVersion v2.0.0
     * @apiDescription app可选值:[qq]. 登录成功之后会在success_redirect中携带token返回
     *
     * @apiParam {String} success_redirect 成功之后的跳转URL(需要urlencode)
     * @apiParam {String} failed_redirect 失败之后跳转的URL(需要urlencode)
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function socialiteLogin(Request $request, ConfigServiceInterface $configService, $app)
    {
        /**
         * @var ConfigService $configService
         */

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
        $redirectUrl = route('api.v2.login.socialite.callback', [$app]);

        $successRedirectUrl = urldecode($request->input('s_url'));
        $failedRedirectUrl = urldecode($request->input('f_url'));

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
}
