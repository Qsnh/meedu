<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V2;

use App\Bus\AuthBus;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Constant\CacheConstant;
use App\Constant\FrontendConstant;
use App\Exceptions\ApiV2Exception;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Auth;
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
    public function wechatMiniMobile(Request $request)
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

        $mini = Factory::miniProgram($this->configService->getTencentWechatMiniConfig());

        // 解密获取手机号
        $data = $mini->encryptor->decryptData($sessionKey, $iv, $encryptedData);
        $mobile = $data['phoneNumber'];
        // 解密获取用户信息
        $userData = $mini->encryptor->decryptData($sessionKey, $userInfo['iv'], $userInfo['encryptedData']);

        $user = $this->userService->findMobile($mobile);
        $socialites = [];
        if (!$user) {
            // 直接注册
            $user = $this->userService->createWithMobile($mobile, '', $userData['nickName'], $userData['avatarUrl']);
        } else {
            // socialite
            $socialites = $this->socialiteService->userSocialites($user['id']);
            $socialites = array_column($socialites, null, 'app');
        }
        if (!isset($socialites[FrontendConstant::WECHAT_MINI_LOGIN_SIGN])) {
            // 未绑定socialite
            $this->socialiteService->bindApp($user['id'], FrontendConstant::WECHAT_MINI_LOGIN_SIGN, $openid, $userData);
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
    public function wechatMini(Request $request)
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

        $userId = $this->socialiteService->getBindUserId(FrontendConstant::WECHAT_MINI_LOGIN_SIGN, $openid);
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
        if ($user['is_lock'] === FrontendConstant::YES) {
            throw new ServiceException(__(ApiV2Constant::MEMBER_HAS_LOCKED));
        }

        /**
         * @var AuthBus $authBus
         */
        $authBus = app()->make(AuthBus::class);

        return $authBus->tokenLogin($user['id'], get_platform());
    }

    /**
     * @OA\Get(
     *     path="/login/socialites",
     *     summary="社交登录app列表",
     *     tags={"Auth"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="array",description="",@OA\Items(ref="#/components/schemas/SocailiteApp")),
     *         )
     *     )
     * )
     */
    public function socialiteApps()
    {
        $apps = $this->configService->getEnabledSocialiteApps();
        $apps = array_map(function ($app) {
            $app['logo'] = url($app['logo']);

            // 授权地址
            if (!($app['url'] ?? '')) {
                $app['url'] = route('socialite', $app['app']);
            }

            return $app;
        }, $apps);

        return $this->data($apps);
    }
}
