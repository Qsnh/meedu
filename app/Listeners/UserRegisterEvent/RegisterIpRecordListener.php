<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
