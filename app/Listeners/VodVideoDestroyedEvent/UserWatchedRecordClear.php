<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\VodVideoDestroyedEvent;

use App\Events\VodVideoDestroyedEvent;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class UserWatchedRecordClear
{

    /**
     * @var UserService $userService
     */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(VodVideoDestroyedEvent $event)
    {
        $this->userService->clearVideoWatchRecords($event->id);
    }
}
