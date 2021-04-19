<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Api\V2;

use App\Bus\AuthBus;
use App\Meedu\Wechat;
use App\Meedu\WechatMini;
use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Constant\CacheConstant;
use App\Exceptions\ApiV2Exception;
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

/**
 * @OpenApi\Annotations\Schemas(
 *     @OA\Schema(
 *         schema="SocailiteApp",
 *         type="object",
 *         title="社交登录APP",
 *         @OA\Property(property="app",type="string",description="app"),
 *         @OA\Property(property="name",type="string",description="名称"),
 *         @OA\Property(property="url",type="string",description="地址"),
 *         @OA\Property(property="logo",type="string",description="logo"),
 *     ),
 * )
 */
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
    ) {
        $this->userService = $userService;
        $this->configService = $configService;
        $this->cacheService = $cacheService;
        $this->socialiteService = $socialiteService;
    }

    /**
     * @OA\Post(
     *     path="/login/password",
     *     summary="密码登录",
     *     tags={"Auth"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="mobile",description="手机号",type="string"),
     *         @OA\Property(property="password",description="密码",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="token",type="string",description="token"),
     *             ),
     *         )
     *     )
     * )
     *
     * @param PasswordLoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordLogin(PasswordLoginRequest $request)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();
        $user = $this->userService->passwordLogin($mobile, $password);
        if (!$user) {
            return $this->error(__(ApiV2Constant::MOBILE_OR_PASSWORD_ERROR));
        }

        try {
            $token = $this->token($user);

            return $this->data(compact('token'));
        } catch (ServiceException $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/login/mobile",
     *     summary="手机短信登录",
     *     tags={"Auth"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="mobile",description="手机号",type="string"),
     *         @OA\Property(property="mobile_code",description="手机验证码",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="token",type="string",description="token"),
     *             ),
     *         )
     *     )
     * )
     *
     * @param MobileLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiV2Exception
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
     * @OA\Post(
     *     path="/login/wechatMiniMobile",
     *     summary="微信小程序手机号登录",
     *     tags={"Auth"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="openid",description="openid",type="string"),
     *         @OA\Property(property="iv",description="iv",type="string"),
     *         @OA\Property(property="encryptedData",description="encryptedData",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="token",type="string",description="token"),
     *             ),
     *         )
     *     )
     * )
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
            return $this->error(__('error'));
        }

        $sessionKey = $this->cacheService->get(get_cache_key(CacheConstant::WECHAT_MINI_SESSION_KEY['name'], $openid));
        if (!$sessionKey) {
            return $this->error(__('error'));
        }

        // 校验签名
        if (sha1($userInfo['rawData'] . $sessionKey) !== $userInfo['signature']) {
            return $this->error(__('params error'));
        }

        $mini = WechatMini::getInstance();

        // 解密获取手机号
        $data = $mini->encryptor->decryptData($sessionKey, $iv, $encryptedData);
        $mobile = $data['phoneNumber'];
        // 解密获取用户信息
        $userData = $mini->encryptor->decryptData($sessionKey, $userInfo['iv'], $userInfo['encryptedData']);

        if ($openid !== $userData['openId']) {
            return $this->error(__('error'));
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
     * @OA\Post(
     *     path="/login/wechatMini",
     *     summary="微信小程序静默授权登录",
     *     tags={"Auth"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="openid",description="openid",type="string"),
     *         @OA\Property(property="iv",description="iv",type="string"),
     *         @OA\Property(property="rawData",description="rawData",type="string"),
     *         @OA\Property(property="signature",description="signature",type="string"),
     *         @OA\Property(property="encryptedData",description="encryptedData",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="token",type="string",description="token"),
     *             ),
     *         )
     *     )
     * )
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
            return $this->error(__('error'));
        }

        $sessionKey = $this->cacheService->get(get_cache_key(CacheConstant::WECHAT_MINI_SESSION_KEY['name'], $openid));
        if (!$sessionKey) {
            return $this->error(__('error'));
        }

        // 验签
        if (sha1($raw . $sessionKey) !== $signature) {
            return $this->error(__('error'));
        }

        // 解密获取用户信息
        $userData = WechatMini::getInstance()->encryptor->decryptData($sessionKey, $iv, $encryptedData);

        if ($openid !== $userData['openId']) {
            return $this->error(__('error'));
        }

        // unionId
        $unionId = $userData['unionId'] ?? '';

        $userId = $authBus->wechatMiniLogin($openid, $unionId);
        if (!$userId) {
            return $this->error(__('error'));
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
            throw new ServiceException(__(ApiV2Constant::MEMBER_HAS_LOCKED));
        }

        /**
         * @var AuthBus $authBus
         */
        $authBus = app()->make(AuthBus::class);

        return $authBus->tokenLogin($user['id'], get_platform());
    }

    // 微信公众号授权登录
    public function wechatLogin(Request $request)
    {
        $successRedirect = $request->input('success_redirect');
        $failedRedirect = $request->input('failed_redirect');

        if (!$successRedirect || !$failedRedirect) {
            return $this->error(__('params error'));
        }

        $redirectUrl = route('api.v2.login.wechat.callback');
        $redirectUrl = url_append_query($redirectUrl, ['s_url' => urlencode($successRedirect), 'f_url' => urlencode($failedRedirect)]);

        return Wechat::getInstance()->oauth->redirect($redirectUrl);
    }

    // 微信公众号授权登录[回调]
    public function wechatLoginCallback(Request $request, AuthBus $authBus)
    {
        $successRedirectUrl = $request->input('s_url');
        $failedRedirectUrl = $request->input('f_url');

        $user = Wechat::getInstance()->oauth->user();

        if (!$user) {
            return redirect(url_append_query($failedRedirectUrl, ['msg' => __('error')]));
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

    // 社交登录
    public function socialiteLogin(Request $request, ConfigServiceInterface $configService, $app)
    {
        /**
         * @var ConfigService $configService
         */

        $successRedirect = $request->input('success_redirect');
        $failedRedirect = $request->input('failed_redirect');

        if (!$successRedirect || !$failedRedirect) {
            return $this->error(__('params error'));
        }

        $enabledSocialites = $configService->getEnabledSocialiteApps();
        if (!in_array($app, array_column($enabledSocialites, 'app'))) {
            return $this->error(__('params error'));
        }

        // 修改回调地址
        $redirectUrl = route('api.v2.login.socialite.callback', [$app]);
        $redirectUrl = url_append_query($redirectUrl, ['s_url' => urlencode($successRedirect), 'f_url' => urlencode($failedRedirect)]);
        config(['services.' . $app . '.redirect' => $redirectUrl]);

        return Socialite::driver($app)->stateless()->redirect();
    }

    // 社交登录回调
    public function socialiteLoginCallback(Request $request, $app)
    {
        $successRedirectUrl = $request->input('s_url');
        $failedRedirectUrl = $request->input('f_url');

        $user = Socialite::driver($app)->stateless()->user();

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
