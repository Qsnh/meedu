<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners\UserRegisterEvent;

use App\Events\UserRegisterEvent;
use App\Jobs\UserRegisterIpToAreaJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class RegisterIpRecordListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * RegisterIpRecordListener constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param UserRegisterEvent $event
     * @return void
     */
    public function handle(UserRegisterEvent $event)
    {
        $ip = request()->getClientIp();
        $this->userService->setRegisterIp($event->userId, $ip);

        dispatch(new UserRegisterIpToAreaJob($event->userId))->delay(3);
    }
}
