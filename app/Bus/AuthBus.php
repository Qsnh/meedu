<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Bus;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Events\UserLoginEvent;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Member\Services\SocialiteService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;

class AuthBus
{
    const SOCIALITE_TOKEN_WAY_KEY = 'socialite_token_way';
    const SOCIALITE_PLATFORM = 'socialite_platform';
    const SOCIALITE_REDIRECT_TO = 'socialite_login_redirect';

    public function webLogin(int $userId, int $remember, string $platform): void
    {
        Auth::loginUsingId($userId, $remember);
        $this->login($userId, $platform, Carbon::now()->toDateTimeString());
    }

    public function tokenLogin(int $userId, string $platform)
    {
        $loginAt = Carbon::now();
        $token = Auth::guard('apiv2')->claims(['last_login_at' => $loginAt->timestamp])->tokenById($userId);

        $this->login($userId, $platform, $loginAt->toDateTimeString());

        return $token;
    }

    public function recordSocialiteTokenWay()
    {
        session([self::SOCIALITE_TOKEN_WAY_KEY => request()->has('use_token')]);
    }

    public function recordSocialitePlatform()
    {
        $platform = request()->input('platform');
        if (!$platform) {
            $platform = is_h5() ? FrontendConstant::LOGIN_PLATFORM_H5 : FrontendConstant::LOGIN_PLATFORM_PC;
        }

        session([self::SOCIALITE_PLATFORM => $platform]);
    }

    public function recordSocialiteRedirectTo($redirectTo)
    {
        session([self::SOCIALITE_REDIRECT_TO => $redirectTo]);
    }

    public function socialiteLogin(int $userId, string $platform = null, $tokenWay = null): string
    {
        if (is_null($tokenWay)) {
            $tokenWay = session(self::SOCIALITE_TOKEN_WAY_KEY);
        }
        if (is_null($platform)) {
            $platform = session(self::SOCIALITE_PLATFORM);
        }

        if (!$tokenWay) {
            $this->webLogin($userId, true, $platform);
            return '';
        }
        return $this->tokenLogin($userId, $platform);
    }

    protected function login(int $userId, string $platform, string $loginAt)
    {
        event(new UserLoginEvent($userId, $platform, $loginAt));
    }

    /**
     * 社交账户绑定
     *
     * @param $app
     * @param $appId
     * @param $userData
     * @param $mobile
     * @return int
     */
    public function socialiteMobileBind($app, $appId, $userData, $mobile)
    {
        return DB::transaction(function () use ($app, $appId, $userData, $mobile) {
            /**
             * @var SocialiteService $socialiteService
             */
            $socialiteService = app()->make(SocialiteServiceInterface::class);

            /**
             * @var UserService $userService
             */
            $userService = app()->make(UserServiceInterface::class);

            if ($userService->findMobile($mobile)) {
                throw new ServiceException(__('mobile has exists'));
            }

            /**
             * @var ConfigService $configService
             */
            $configService = app()->make(ConfigServiceInterface::class);

            if ($socialiteService->getBindUserId($app, $appId)) {
                throw new ServiceException(__('socialite_account_has_bind_user'));
            }

            // 创建新用户
            $nickname = $userData['nickname'] ? $userData['nickname'] . Str::random(3) : Str::random(6);
            $avatar = $userData['avatar'] ?? url($configService->getMemberDefaultAvatar());
            $user = $userService->createWithMobile($mobile, '', $nickname, $avatar);

            // 将社交账号与新用户绑定
            $socialiteService->bindApp($user['id'], $app, $appId, $userData);

            return $user['id'];
        });
    }

    public function socialiteRedirectTo($token = '')
    {
        if ($redirect = session(self::SOCIALITE_REDIRECT_TO)) {
            $redirect .= (strpos($redirect, '?') === false ? '?' : '&') . 'token=' . $token;
            return $redirect;
        }

        return $this->redirectTo();
    }

    public function redirectTo()
    {
        $redirectTo = session(FrontendConstant::LOGIN_CALLBACK_URL_KEY);
        $redirectTo = $redirectTo ?: route('index');
        return $redirectTo;
    }
}
