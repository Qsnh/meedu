<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserVerifyFaceSuccessEvent;

use App\Events\UserVerifyFaceSuccessEvent;
use App\Meedu\ServiceV2\Services\UserServiceInterface;

class UserProfileUpdateListener
{
    public $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\UserVerifyFaceSuccessEvent $event
     * @return void
     */
    public function handle(UserVerifyFaceSuccessEvent $event)
    {
        $this->userService->change2Verified($event->userId, $event->name, $event->idNumber, $event->verifyImageUrl);
    }
}
