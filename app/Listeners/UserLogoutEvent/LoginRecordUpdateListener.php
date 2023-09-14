<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserLogoutEvent;

use App\Events\UserLogoutEvent;
use App\Meedu\ServiceV2\Services\UserServiceInterface;

class LoginRecordUpdateListener
{
    public $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(UserLogoutEvent $event)
    {
        $tokenPayload = token_payload($event->token);
        $this->userService->jtiLogout($event->userId, $tokenPayload['jti']);
    }
}
