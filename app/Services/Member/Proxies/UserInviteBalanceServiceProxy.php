<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Member\Proxies;

use App\Meedu\ServiceProxy\ServiceProxy;
use App\Services\Member\Services\UserInviteBalanceService;
use App\Services\Member\Interfaces\UserInviteBalanceServiceInterface;

class UserInviteBalanceServiceProxy extends ServiceProxy implements UserInviteBalanceServiceInterface
{
    public function __construct(UserInviteBalanceService $service)
    {
        parent::__construct($service);
    }
}
