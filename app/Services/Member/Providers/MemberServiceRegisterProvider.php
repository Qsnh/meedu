<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Member\Services\RoleService;
use App\Services\Member\Services\CreditService;
use App\Services\Member\Services\DeliverService;
use App\Services\Member\Proxies\UserServiceProxy;
use App\Services\Member\Services\SocialiteService;
use App\Services\Member\Services\NotificationService;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\CreditServiceInterface;
use App\Services\Member\Interfaces\DeliverServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class MemberServiceRegisterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance(UserServiceInterface::class, $this->app->make(UserServiceProxy::class));
        $this->app->instance(RoleServiceInterface::class, $this->app->make(RoleService::class));
        $this->app->instance(DeliverServiceInterface::class, $this->app->make(DeliverService::class));
        $this->app->instance(NotificationServiceInterface::class, $this->app->make(NotificationService::class));
        $this->app->instance(SocialiteServiceInterface::class, $this->app->make(SocialiteService::class));
        $this->app->instance(CreditServiceInterface::class, $this->app->make(CreditService::class));
    }
}
