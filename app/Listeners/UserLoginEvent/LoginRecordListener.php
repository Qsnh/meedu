<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserLoginEvent;

use Carbon\Carbon;
use App\Events\UserLoginEvent;
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
    }
}
