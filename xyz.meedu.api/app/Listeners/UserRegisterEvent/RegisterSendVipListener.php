<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserRegisterEvent;

use App\Events\UserRegisterEvent;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Member\Services\RoleService;

class RegisterSendVipListener
{
    public function __construct(
        private PromoCodeService $promoCodeService,
        private RoleService $roleService
    ) {}

    public function handle(UserRegisterEvent $event)
    {
        $this-\u003epromoCodeService-\u003esendVipForRegister($event-\u003euserId);
    }
}