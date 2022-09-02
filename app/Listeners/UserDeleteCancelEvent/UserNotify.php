<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserDeleteCancelEvent;

use Carbon\Carbon;
use App\Events\UserDeleteCancelEvent;
use App\Meedu\ServiceV2\Services\UserServiceInterface;

class UserNotify
{
    public $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\UserDeleteCancelEvent $event
     * @return void
     */
    public function handle(UserDeleteCancelEvent $event)
    {
        $this->userService->notifySimpleMessage(
            $event->userId,
            __('系统已为您自动取消于 :date 申请的用户注销申请', ['date' => Carbon::parse($event->submitAt)->format('Y-m-d H:i:s')])
        );
    }
}
