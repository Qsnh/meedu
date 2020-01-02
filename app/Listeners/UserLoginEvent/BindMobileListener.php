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

use App\Events\UserLoginEvent;
use App\Businesses\BusinessState;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Member\Services\UserService;
use App\Services\Member\Services\NotificationService;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class BindMobileListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $businessState;
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * BindMobileListener constructor.
     * @param BusinessState $businessState
     * @param UserServiceInterface $userService
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(
        BusinessState $businessState,
        UserServiceInterface $userService,
        NotificationServiceInterface $notificationService
    ) {
        $this->businessState = $businessState;
        $this->userService = $userService;
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param UserLoginEvent $event
     * @return void
     */
    public function handle(UserLoginEvent $event)
    {
        $user = $this->userService->find($event->userId);
        if (!$this->businessState->isNeedBindMobile($user)) {
            return;
        }
        $this->notificationService->notifyBindMobileMessage($event->userId);
    }
}
