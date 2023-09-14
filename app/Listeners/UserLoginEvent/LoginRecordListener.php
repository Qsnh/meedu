<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserLoginEvent;

use App\Events\UserLoginEvent;
use App\Meedu\ServiceV2\Services\UserServiceInterface;

class LoginRecordListener
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(UserLoginEvent $event)
    {
        $this->userService->storeUserLoginRecord(
            $event->userId,
            $event->token,
            $event->platform,
            $event->ua,
            $event->ip
        );
    }
}
