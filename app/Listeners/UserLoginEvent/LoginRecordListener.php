<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\UserLoginEvent;

use Carbon\Carbon;
use App\Events\UserLoginEvent;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Cookie;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class LoginRecordListener
{

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * LoginRecordListener constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param UserLoginEvent $event
     * @return void
     */
    public function handle(UserLoginEvent $event)
    {
        $ip = request()->getClientIp();
        $at = $event->at ? Carbon::parse($event->at) : Carbon::now();

        $this->userService->createLoginRecord($event->userId, $event->platform, $ip, $at);

        if ($event->platform === FrontendConstant::LOGIN_PLATFORM_H5 || $event->platform === FrontendConstant::LOGIN_PLATFORM_PC) {
            // 将登录时间写入cookie
            // 有效时间：默认15天
            Cookie::queue(FrontendConstant::USER_LOGIN_AT_COOKIE_NAME, $at->timestamp, 3600 * 24 * 15);
        }
    }
}
