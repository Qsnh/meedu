<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use Carbon\Carbon;
use App\Events\UserLoginEvent;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use App\Services\Member\Services\UserService;
use App\Services\Member\Services\SocialiteService;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;

class AuthBus
{
    public function tokenLogin(int $userId, string $platform)
    {
        $loginAt = Carbon::now();

        $token = Auth::guard('apiv2')
            ->claims([
                // 分发的token携带最后一次登录时间
                FrontendConstant::USER_LOGIN_AT_COOKIE_NAME => $loginAt->timestamp,
            ])
            ->tokenById($userId);

        event(new UserLoginEvent($userId, $platform, $loginAt->toDateTimeLocalString()));

        return $token;
    }

    public function wechatLogin(string $openId, string $unionId, $data): int
    {
        /**
         * @var SocialiteService $socialiteService
         */
        $socialiteService = app()->make(SocialiteServiceInterface::class);

        if ($unionId && $socialiteRecord = $socialiteService->findUnionId($unionId)) {
            return $socialiteRecord['user_id'];
        }

        $socialiteRecord = $socialiteService->findBind(FrontendConstant::WECHAT_LOGIN_SIGN, $openId);
        if ($socialiteRecord) {
            // 更新unionId
            $unionId && $socialiteService->updateUnionId($socialiteRecord['id'], $unionId);

            return $socialiteRecord['user_id'];
        }

        // 创建新的用户
        $data = [
            'nickname' => $data['nickname'] ?? '',
            'avatar' => $data['headimgurl'] ?? '',
        ];

        return $socialiteService->bindAppWithNewUser(FrontendConstant::WECHAT_LOGIN_SIGN, $openId, $data, $unionId);
    }

    public function wechatMiniLogin(string $openId, string $unionId)
    {
        /**
         * @var SocialiteService $socialiteService
         */
        $socialiteService = app()->make(SocialiteServiceInterface::class);

        if ($unionId && $socialiteRecord = $socialiteService->findUnionId($unionId)) {
            return $socialiteRecord['user_id'];
        }

        $socialiteRecord = $socialiteService->findBind(FrontendConstant::WECHAT_MINI_LOGIN_SIGN, $openId);
        if ($socialiteRecord) {
            // 更新unionId
            $unionId && $socialiteService->updateUnionId($socialiteRecord['id'], $unionId);

            return $socialiteRecord['user_id'];
        }

        return 0;
    }

    public function wechatMiniMobileLogin(string $openId, string $unionId, string $mobile, $data)
    {
        /**
         * @var SocialiteService $socialiteService
         */
        $socialiteService = app()->make(SocialiteServiceInterface::class);
        /**
         * @var UserService $userService
         */
        $userService = app()->make(UserServiceInterface::class);

        $user = $userService->findMobile($mobile);
        $userSocialites = [];

        if ($user) {
            // 读取已经绑定的socialite
            $userSocialites = $socialiteService->userSocialites($user['id']);
        } else {
            // 创建新的账户
            $user = $userService->createWithMobile($mobile, '', $data['nickName'], $data['avatarUrl']);
        }

        if (!in_array(FrontendConstant::WECHAT_MINI_LOGIN_SIGN, array_column($userSocialites, 'app'))) {
            // 当前用户未绑定当前的小程序账户的话
            $socialiteService->bindApp($user['id'], FrontendConstant::WECHAT_MINI_LOGIN_SIGN, $openId, $data, $unionId);
        }

        return $user;
    }
}
