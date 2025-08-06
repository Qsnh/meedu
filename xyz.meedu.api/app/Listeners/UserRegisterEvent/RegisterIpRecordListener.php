<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserRegisterEvent;

use App\Events\UserRegisterEvent;
use App\Services\Member\Services\UserService;
use Illuminate\Support\Facades\Request;

class RegisterIpRecordListener
{
    public function __construct(private UserService $userService) {}

    public function handle(UserRegisterEvent $event)
    {
        $this-\u003euserService-\u003eupdateRegisterIp($event-\u003euserId, Request::ip());
    }
}