<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use App\Bus\AuthBus;
use App\Meedu\Wechat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Constant\CacheConstant;
use App\Meedu\Utils\AppRedirect;
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
    public function wechatOauthLogin(SocialiteLoginRequest $request)
    {
        $sUrl = $request->input('s_url');//登录成功之后跳转的地址
        $fUrl = $request->input('f_url');//登录失败跳转的地址-失败的话会在fUrl中携带msg参数

        $appRedirect = new AppRedirect(
            route('api.v3.login.wechat.callback'),
            ['s_url' => $sUrl, 'f_url' => $fUrl]
        );

        return Wechat::getInstance()->oauth->redirect($appRedirect->getRedirectUrl());
    }

    public function wechatScanLoginCallback(Request $request)
    {
        $data = $request->input('data');
        if (!$data) {
            return $this->error(__('参数错误'));
        }

        $baseUrl = config('app.url');
        $appRedirect = new AppRedirect();
        $fUrl = $baseUrl;

        try {
            $data = $appRedirect->decrypt($data);
            if ($data === false) {
                throw new ServiceException(__('授权登录失败[1001]'));
            }

            $sUrl = $data['s_url'] ?: $baseUrl;
            $fUrl = $data['f_url'] ?: $baseUrl;

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

            return redirect(url_append_query($sUrl, ['code' => $code]));
        } catch (ServiceException $e) {
            return redirect(url_append_query($fUrl, ['msg' => $e->getMessage()]));
        }
    }

    public function socialiteLogin(ConfigServiceInterface $configService, SocialiteLoginRequest $request, $app)
    {
        $enabledSocialites = $configService->getEnabledSocialiteApps();
        if (!in_array($app, array_column($enabledSocialites, 'app'))) {
            return $this->error(__('登录应用不存在'));
        }

        $sUrl = $request->input('s_url');//登录成功之后跳转的地址
        $fUrl = $request->input('f_url');//登录失败跳转的地址-失败的话会在fUrl中携带msg参数

        $appRedirect = new AppRedirect(
            route('api.v3.login.socialite.callback', [$app]),
            ['s_url' => $sUrl, 'f_url' => $fUrl]
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

        try {
            $data = $appRedirect->decrypt($data);
            if ($data === false) {
                throw new ServiceException(__('授权登录失败[1001]'));
            }

            $sUrl = $data['s_url'] ?: $baseUrl;
            $fUrl = $data['f_url'] ?: $baseUrl;

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

            return redirect(url_append_query($sUrl, ['code' => $code]));
        } catch (ServiceException $e) {
            return redirect(url_append_query($fUrl, ['msg' => $e->getMessage()]));
        }
    }

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
                    'token' => $token,
                ]);
            } elseif ($userId === AuthBus::ERROR_CODE_BIND_MOBILE) {//强制绑定手机号
                return $this->data(['bind_mobile' => 1, 'code' => $code]);
            }

            throw new ServiceException(__('未知错误'));
        } catch (ServiceException $e) {
            return $this->error($e->getMessage());
        }
    }

    public function registerWithSocialite(Request $request, AuthBus $authBus)
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
            $nickname = $data['nickname'];
            $avatar = $data['avatar'];

            $userId = $authBus->registerWithSocialite($mobile, $app, $openid, $unionId, $nickname, $avatar, $data);

            Cache::forget($cacheKey);

            $token = $authBus->tokenLogin($userId, get_platform());

            return $this->data([
                'token' => $token,
            ]);
        } catch (ServiceException $e) {
            return $this->error($e->getMessage());
        }
    }
}
