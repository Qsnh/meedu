<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserRegisterEvent;

use App\Events\UserRegisterEvent;
use App\Services\Member\Services\CreditService;

class RegisterCredit1RewardListener
{
    public function __construct(private CreditService $creditService) {}

    public function handle(UserRegisterEvent $event)
    {
        $this->creditService->createRegisterEvent($event->userId);
    }
}