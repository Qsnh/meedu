<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Events\UserLoginEvent;
use App\Businesses\BusinessState;
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
    public const ERROR_CODE_BIND_MOBILE = -100;

    /**
     * @var SocialiteService
     */
    protected $socialiteService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(
        SocialiteServiceInterface $socialiteService,
        UserServiceInterface      $userService,
        ConfigServiceInterface    $configService
    ) {
        $this->socialiteService = $socialiteService;
        $this->userService = $userService;
        $this->configService = $configService;
    }

    public function tokenLogin(int $userId, string $platform)
    {
        $token = Auth::guard(FrontendConstant::API_GUARD)->tokenById($userId);
        event(new UserLoginEvent($userId, $platform, request()->getClientIp(), request_ua(), $token));
        return $token;
    }

    public function wechatLogin(string $openId, string $unionId, $data): int
    {
        if ($unionId && $socialiteRecord = $this->socialiteService->findUnionId($unionId)) {
            return $socialiteRecord['user_id'];
        }

        $socialiteRecord = $this->socialiteService->findBind(FrontendConstant::WECHAT_LOGIN_SIGN, $openId);
        if ($socialiteRecord) {
            // 更新unionId
            $unionId && $this->socialiteService->updateUnionId($socialiteRecord['id'], $unionId);

            return $socialiteRecord['user_id'];
        }

        if ($this->configService->getEnabledMobileBindAlert() === 1) {//强制绑定手机号
            return self::ERROR_CODE_BIND_MOBILE;
        }

        // 创建新的用户
        $data = [
            'nickname' => $data['nickname'] ?? '',
            'avatar' => $data['headimgurl'] ?? '',
        ];

        return $this->socialiteService->bindAppWithNewUser(FrontendConstant::WECHAT_LOGIN_SIGN, $openId, $data, $unionId);
    }

    public function socialiteLogin(string $app, string $id, array $data)
    {
        $userId = $this->socialiteService->getBindUserId($app, $id);
        if ($userId > 0) {
            return $userId;
        }
        if ($this->configService->getEnabledMobileBindAlert() === 1) {//强制绑定手机号
            return self::ERROR_CODE_BIND_MOBILE;
        }
        // 自动创建新用户
        return $this->socialiteService->bindAppWithNewUser($app, $id, $data);
    }

    public function registerWithSocialite(
        string $mobile,
        string $app,
        string $appId,
        string $unionId,
        string $nickname,
        string $avatar,
        array  $data
    ) {
        return DB::transaction(function () use ($mobile, $app, $appId, $unionId, $nickname, $avatar, $data) {
            $user = $this->userService->findMobile($mobile);
            if ($user) {
                throw new ServiceException(__('手机号已存在'));
            }

            /**
             * @var BusinessState $bus
             */
            $bus = app()->make(BusinessState::class);
            $bus->socialiteBindCheck(0, $app, $appId);

            // 创建用户
            $user = $this->userService->createWithMobile($mobile, '', $nickname, $avatar);

            $this->socialiteService->bindApp($user['id'], $app, $appId, $data, $unionId);

            return $user['id'];
        });
    }
}
