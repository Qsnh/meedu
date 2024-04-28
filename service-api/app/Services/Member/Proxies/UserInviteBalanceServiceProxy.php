<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
