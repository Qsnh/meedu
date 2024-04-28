<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use App\Bus\AuthBus;
use App\Meedu\Wechat;
use App\Bus\WechatScanBus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Constant\CacheConstant;
use App\Meedu\Utils\AppRedirect;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\V2\BaseController;
use App\Http\Requests\ApiV3\SocialiteLoginRequest;
use App\Meedu\ServiceV2\Services\UserServiceInterface;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class LoginController extends BaseController
{

    /**
     * @api {GET} /api/v3/auth/login/wechat/oauth 微信公众号授权登录
     * @apiGroup Auth-V3
     * @apiName  AuthLoginWechatOauth
     * @apiVersion v3.0.0
     * @apiDescription v4.8新增
     *
     * @apiParam {String} s_url 登录成功跳转地址
     * @apiParam {String} f_url 登录失败跳转地址
     * @apiParam {String=login,bind} action 行为[login:登录,bind:绑定]
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function wechatOauthLogin(SocialiteLoginRequest $request)
    {
        $sUrl = $request->input('s_url');//登录成功之后跳转的地址
        $fUrl = $request->input('f_url');//登录失败跳转的地址-失败的话会在fUrl中携带msg参数
        $action = $request->input('action');

        $appRedirect = new AppRedirect(
            route('api.v3.login.wechat.callback'),
            ['s_url' => $sUrl, 'f_url' => $fUrl, 'action' => $action]
        );

        return Wechat::getInstance()->oauth->redirect($appRedirect->getRedirectUrl());
    }

    public function wechatOauthCallback(Request $request)
    {
        $data = $request->input('data');
        if (!$data) {
            return $this->error(__('参数错误'));
        }

        $baseUrl = config('app.url');
        $appRedirect = new AppRedirect();
        $fUrl = $baseUrl;
        $action = '';

        try {
            $data = $appRedirect->decrypt($data);
            if ($data === false) {
                throw new ServiceException(__('授权登录失败[1001]'));
            }

            $sUrl = $data['s_url'] ?: $baseUrl;
            $fUrl = $data['f_url'] ?: $baseUrl;
            $action = $data['action'] ?? '';

            $appUser = Wechat::getInstance()->oauth->user();
            if (!$appUser) {
                throw new ServiceException(__('系统错误'));
            }

            $appUserData = $appUser->getOriginal();

            // 写入缓存
            $code = Str::random(32);
            Cache::put(
                get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code),
                serialize([
                    'type' => 'socialite',
                    'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
                    'data' => [
                        'openid' => $appUser->getId(),
                        'unionid' => $appUserData['unionid'] ?? '',
                        'nickname' => $appUser->getName() ?: $appUser->getNickname(),
                        'avatar' => $appUser->getAvatar(),
                        'original' => $appUser->toArray(),
                    ],
                ]),
                CacheConstant::USER_SOCIALITE_LOGIN['expire']
            );

            return redirect(url_append_query($sUrl, ['login_code' => $code, 'action' => $action]));
        } catch (ServiceException $e) {
            return redirect(url_append_query($fUrl, ['login_err_msg' => $e->getMessage(), 'action' => $action]));
        }
    }

    /**
     * @api {GET} /api/v3/auth/login/socialite/{app} 社交账号登录
     * @apiGroup Auth-V3
     * @apiName  AuthLoginSocialite
     * @apiVersion v3.0.0
     * @apiDescription v4.8新增
     *
     * @apiParam {String} s_url 登录成功跳转地址
     * @apiParam {String} f_url 登录失败跳转地址
     * @apiParam {String=login,bind} action 行为[login:登录,bind:绑定]
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function socialiteLogin(ConfigServiceInterface $configService, SocialiteLoginRequest $request, $app)
    {
        $enabledSocialites = $configService->getEnabledSocialiteApps();
        if (!in_array($app, array_column($enabledSocialites, 'app'))) {
            return $this->error(__('登录应用不存在'));
        }

        $sUrl = $request->input('s_url');//登录成功之后跳转的地址
        $fUrl = $request->input('f_url');//登录失败跳转的地址-失败的话会在fUrl中携带msg参数
        $action = $request->input('action');

        $appRedirect = new AppRedirect(
            route('api.v3.login.socialite.callback', [$app]),
            ['s_url' => $sUrl, 'f_url' => $fUrl, 'action' => $action]
        );

        return Socialite::driver($app)
            ->redirectUrl($appRedirect->getRedirectUrl())
            ->stateless()
            ->redirect();
    }

    public function socialiteLoginCallback(Request $request, $app)
    {
        $data = $request->input('data');
        if (!$data) {
            return $this->error(__('参数错误'));
        }

        $baseUrl = config('app.url');
        $appRedirect = new AppRedirect(route('api.v3.login.socialite.callback', [$app]));
        $fUrl = $baseUrl;
        $action = '';

        try {
            $data = $appRedirect->decrypt($data);
            if ($data === false) {
                throw new ServiceException(__('授权登录失败[1001]'));
            }

            $sUrl = $data['s_url'] ?: $baseUrl;
            $fUrl = $data['f_url'] ?: $baseUrl;
            $action = $data['action'] ?? '';

            // 获取授权登录成功之后的用户信息
            // 这里需要那再次构建社交登录的回调URL[query可与登录前不一样，但是path必须相同]
            // 部分社交应用会重复检查回调的URL，不一致将会导致无法获取当前用户登录信息，从而授权失败

            /**
             * @var \Laravel\Socialite\AbstractUser $user
             */
            $user = Socialite::driver($app)
                ->redirectUrl($appRedirect->getBaseUrl())
                ->stateless()
                ->user();

            // 写入缓存
            $code = Str::random(32);
            Cache::put(
                get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code),
                serialize([
                    'type' => 'socialite',
                    'app' => $app,
                    'data' => [
                        'openid' => $user->getId(),
                        'nickname' => $user->getName() ?: $user->getNickname(),
                        'avatar' => $user->getAvatar(),
                        'original' => (array)$user,
                    ],
                ]),
                CacheConstant::USER_SOCIALITE_LOGIN['expire']
            );

            return redirect(url_append_query($sUrl, ['login_code' => $code, 'action' => $action]));
        } catch (ServiceException $e) {
            return redirect(url_append_query($fUrl, ['login_err_msg' => $e->getMessage(), 'action' => $action]));
        }
    }

    /**
     * @api {POST} /api/v3/auth/login/code 三方账号登录
     * @apiGroup Auth-V3
     * @apiName  AuthLoginWithCode
     * @apiVersion v3.0.0
     * @apiDescription v4.8新增
     *
     * @apiParam {String} code 社交的登录返回的code
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Number} data.success 是否成功[1:是,0:否]
     * @apiSuccess {String} data.token 登录成功后的用户token[success=1时返回]
     * @apiSuccess {String=bind_mobile} data.action 登录失败后需要进一步操作[bind_mobile:需要现绑定手机号]
     */
    public function loginByCode(Request $request, AuthBus $authBus, UserServiceInterface $userService)
    {
        $code = $request->input('code');
        if (!$code) {
            return $this->error(__('参数错误'));
        }

        try {
            $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
            $value = Cache::get($cacheKey);
            if (!$value) {
                throw new ServiceException(__('已过期'));
            }

            $value = unserialize($value);
            $type = $value['type'] ?? null;
            $app = $value['app'] ?? null;
            $data = $value['data'] ?? [];
            if ($type !== 'socialite' || !$app || !isset($data['openid'])) {
                throw new ServiceException(__('参数错误'));
            }

            $userId = 0;
            if ($app === FrontendConstant::SOCIALITE_APP_QQ) {
                $userId = $authBus->socialiteLogin($app, $data['openid'], $data);
            } elseif ($app === FrontendConstant::WECHAT_LOGIN_SIGN) {
                $userId = $authBus->wechatLogin($data['openid'], $data['unionid'] ?? '', $data);
            }

            if ($userId > 0) {
                // 正常登录
                $user = $userService->findUserById($userId);
                if (!$user) {
                    throw new ServiceException(__('用户不存在'));
                }
                if ($user['is_lock'] === 1) {
                    throw new ServiceException(__('用户已锁定无法登录'));
                }
                $token = $authBus->tokenLogin($userId, get_platform());

                Cache::forget($cacheKey);

                return $this->data([
                    'success' => 1,
                    'token' => $token,
                ]);
            } elseif ($userId === AuthBus::ERROR_CODE_BIND_MOBILE) {//强制绑定手机号
                return $this->data([
                    'success' => 0,
                    'action' => 'bind_mobile',
                    'code' => $code,
                ]);
            }

            throw new ServiceException(__('未知错误'));
        } catch (ServiceException $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @api {POST} /api/v3/auth/register/withSocialite 社交账号注册[绑定手机号]
     * @apiGroup Auth-V3
     * @apiName  AuthRegisterWithCode
     * @apiVersion v3.0.0
     * @apiDescription v4.8新增
     *
     * @apiParam {String} code 社交的登录返回的code
     * @apiParam {String} mobile 手机号
     * @apiParam {String} mobile_code 短信验证码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.token 用户token
     */
    public function registerWithSocialite(Request $request, AuthBus $authBus, UserServiceInterface $userService)
    {
        $mobile = $request->input('mobile');
        $code = $request->input('code');
        if (!$mobile || !$code) {
            return $this->error(__('参数错误'));
        }

        $this->mobileCodeCheck();

        try {
            $cacheKey = get_cache_key(CacheConstant::USER_SOCIALITE_LOGIN['name'], $code);
            $value = Cache::get($cacheKey);
            if (!$value) {
                throw new ServiceException(__('已过期'));
            }

            $value = unserialize($value);
            $type = $value['type'] ?? null;
            $app = $value['app'] ?? null;
            $data = $value['data'] ?? [];

            if ($type !== 'socialite' || !$app || !isset($data['openid'])) {
                throw new ServiceException(__('参数错误'));
            }

            $openid = $data['openid'];
            $unionId = $data['unionid'] ?? '';
            // 昵称-防止重复
            $nickname = $data['nickname'];
            $nickname && $nickname .= '_' . Str::random(4);
            // 头像
            $avatar = $data['avatar'];

            $userId = $authBus->registerWithSocialite($mobile, $app, $openid, $unionId, $nickname, $avatar, $data);

            // 注册默认锁定判断
            $user = $userService->findUserById($userId);
            if ($user['is_lock'] === 1) {
                throw new ServiceException(__('用户已锁定无法登录'));
            }

            Cache::forget($cacheKey);

            $token = $authBus->tokenLogin($userId, get_platform());

            return $this->data(['token' => $token]);
        } catch (ServiceException $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @api {GET} /api/v3/auth/login/wechat/scan 微信公众号扫码登录
     * @apiGroup Auth-V3
     * @apiName  AuthLoginWechatScan
     * @apiVersion v3.0.0
     * @apiDescription v4.8新增
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.code code
     * @apiSuccess {String} data.image 二维码
     */
    public function wechatScan(BusinessState $businessState, WechatScanBus $wechatScanBus)
    {
        if (!$businessState->enabledMpScanLogin()) {
            throw new ServiceException(__('未开启微信公众号扫码登录'));
        }

        $code = $wechatScanBus->generateLoginCode();
        // 该方法会生成携带自定义参数的(上面的code)二维码,用户扫码即可关注
        // 关注之后服务端会收到SCAN+自定义参数的事件
        $image = wechat_qrcode_image($code);

        return $this->data([
            'code' => $code,
            'image' => $image,
        ]);
    }

    /**
     * @api {GET} /api/v3/auth/login/wechat/scan/query 微信公众号扫码登录结果查询
     * @apiGroup Auth-V3
     * @apiName  AuthLoginWechatScanQuery
     * @apiVersion v3.0.0
     * @apiDescription v4.8新增
     *
     * @apiParam {string} code code
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.success 状态[-1:不做任何操作,1:登录成功,0:登录失败]
     * @apiSuccess {String} data.token token
     * @apiSuccess {String} data.code code(失败返回)
     * @apiSuccess {String} data.action action[bind_mobile:绑定手机号](失败返回)
     */
    public function wechatScanQuery(Request $request, AuthBus $authBus, WechatScanBus $wechatScanBus)
    {
        $code = $request->input('code');
        if (!$code) {
            return $this->error(__('参数错误'));
        }

        $userId = $wechatScanBus->getLoginUserId($code);
        if (!$userId) {
            return $this->data(['success' => -1]);
        }

        if ($userId === AuthBus::ERROR_CODE_BIND_MOBILE) {
            return $this->data([
                'success' => 0,
                'action' => 'bind_mobile',
                'code' => $code,
            ]);
        }

        $token = $authBus->tokenLogin($userId, FrontendConstant::LOGIN_PLATFORM_PC);

        return $this->data([
            'success' => 1,
            'token' => $token,
        ]);
    }

    /**
     * @api {POST} /api/v3/auth/register/withWechatScan 微信扫码注册[绑定手机号]
     * @apiGroup Auth-V3
     * @apiName  AuthRegisterWithWechatScan
     * @apiVersion v3.0.0
     * @apiDescription v4.8新增
     *
     * @apiParam {String} code 微信扫码的code
     * @apiParam {String} mobile 手机号
     * @apiParam {String} mobile_code 短信验证码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.token 用户token
     */
    public function registerWithWechatScan(Request $request, AuthBus $authBus, WechatScanBus $wechatScanBus, UserServiceInterface $userService)
    {
        $mobile = $request->input('mobile');
        $code = $request->input('code');
        if (!$mobile || !$code) {
            return $this->error(__('参数错误'));
        }

        $this->mobileCodeCheck();

        $userData = $wechatScanBus->getLoginUser($code);
        if (!$userData) {
            return $this->error(__('已过期'));
        }

        $userId = $authBus->registerWithSocialite(
            $mobile,
            FrontendConstant::WECHAT_LOGIN_SIGN,
            $userData['openid'],
            $userData['unionid'] ?? '',
            '',
            '',
            $userData
        );

        // 注册默认锁定判断
        $user = $userService->findUserById($userId);
        if ($user['is_lock'] === 1) {
            throw new ServiceException(__('用户已锁定无法登录'));
        }

        // 删除缓存
        $wechatScanBus->delLoginUser($code);

        $token = $authBus->tokenLogin($userId, FrontendConstant::LOGIN_PLATFORM_PC);

        return $this->data(['token' => $token]);
    }
}
