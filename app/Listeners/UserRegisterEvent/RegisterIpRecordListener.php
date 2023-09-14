<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserRegisterEvent;

use App\Meedu\Utils\IP;
use App\Events\UserRegisterEvent;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class RegisterIpRecordListener
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(UserRegisterEvent $event)
    {
        $ip = request()->getClientIp();
        $this->userService->setRegisterIp($event->userId, $ip);

        $city = IP::queryCity($ip);
        $this->userService->setRegisterArea($event->userId, $city);
    }
}
