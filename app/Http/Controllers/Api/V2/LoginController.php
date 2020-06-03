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

use Socialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\UserLoginEvent;
use App\Constant\ApiV2Constant;
use App\Constant\FrontendConstant;
use App\Exceptions\ApiV2Exception;
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

    protected $configService;
    protected $cacheService;
    protected $socialiteService;

    /**
     * @param UserServiceInterface $userService
     * @param ConfigService $configService
     * @param CacheService $cacheService
     * @param SocialiteService $socialiteService
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
        if ($user['is_lock'] === FrontendConstant::YES) {
            return $this->error(__(ApiV2Constant::MEMBER_HAS_LOCKED));
        }
        
        $token = Auth::guard($this->guard)->tokenById($user['id']);

        event(new UserLoginEvent($user['id']));

        return $this->data(compact('token'));
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
        if ($user['is_lock'] === FrontendConstant::YES) {
            return $this->error(__(ApiV2Constant::MEMBER_HAS_LOCKED));
        }
        $token = Auth::guard($this->guard)->tokenById($user['id']);

        event(new UserLoginEvent($user['id']));

        return $this->data(compact('token'));
    }

    /**
    * @OA\Get(
    *     path="/login/socialite/{app}",
    *     summary="社交登录",
    *     @OA\Parameter(in="query",name="app",description="社交app",required=true,@OA\Schema(type="string")),
    *     @OA\Parameter(in="query",name="redirect",description="重定向地址",required=true,@OA\Schema(type="string")),
    *     tags={"Auth"},
    *     @OA\Response(
    *         description="",response=200,
    *         @OA\JsonContent(
    *             @OA\Property(property="code",type="integer",description="状态码"),
    *             @OA\Property(property="message",type="string",description="消息"),
    *             @OA\Property(property="data",type="object",description=""),
    *         )
    *     )
    * )
    */
    public function socialite(Request $request, $app)
    {
        $redirect = $request->input('redirect');
        if (!$redirect) {
            abort(406);
        }

        // 记录重定向地址
        $nonce = Str::random(6);
        $this->cacheService->put($nonce, $redirect, 60);

        return Socialite::driver($app)->redirectUrl(route('api.v2.socialite.login.callback', $app))->with(['state' => $nonce])->stateless()->redirect();
    }

    /**
     * 社交登录回调
     *
     * @param Request $request
     * @param string $app
     * @return void
     */
    public function socialiteCallback(Request $request, $app)
    {
        $user = Socialite::driver($app)->stateless()->user();
        $appId = $user->getId();

        // 登录检测
        $userId = $this->socialiteService->getBindUserId($app, $appId);
        if (!$userId) {
            $userId = $this->socialiteService->bindAppWithNewUser($app, $appId, (array)$user);
        }

        // 用户是否锁定检测
        $user = $this->userService->find($userId);
        if ($user['is_lock'] === FrontendConstant::YES) {
            return $this->error(__('current user was locked,please contact administrator'));
        }

        // 登录
        $token = Auth::guard($this->guard)->tokenById($user['id']);

        // 登录事件
        event(new UserLoginEvent($userId));

        $nonce = $request->input('state');
        $redirect = $this->cacheService->pull($nonce, '');

        $redirect .= (strpos($redirect, '?') === false ? '?' : '&'). 'token=' . $token;
        return redirect($redirect . '?token=' . $token);
    }

    /**
    * @OA\Get(
    *     path="/login/socialites",
    *     summary="社交登录app",
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
            $app['url'] = route('api.v2.socialite.login', $app['app']);
            return $app;
        }, $apps);

        return $this->data($apps);
    }
}
