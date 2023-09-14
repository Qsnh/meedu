<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserLoginEvent;

use App\Events\UserLoginEvent;
use App\Exceptions\ServiceException;
use App\Meedu\ServiceV2\Services\UserServiceInterface;

class UserDeleteCancelListener
{
    public $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\UserLoginEvent $event
     * @return void
     */
    public function handle(UserLoginEvent $event)
    {
        try {
            $this->userService->cancelUserDelete($event->userId);
        } catch (ServiceException $e) {
            //
        }
    }
}
