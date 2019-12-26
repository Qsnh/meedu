<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Other\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Other\Services\NavService;
use App\Services\Other\Services\SmsService;
use App\Services\Other\Services\LinkService;
use App\Services\Other\Proxies\NavServiceProxy;
use App\Services\Other\Proxies\SmsServiceProxy;
use App\Services\Other\Proxies\LinkServiceProxy;
use App\Services\Other\Services\AnnouncementService;
use App\Services\Other\Proxies\AnnouncementServiceProxy;

class OtherServiceRegisterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance(NavService::class, $this->app->make(NavServiceProxy::class));
        $this->app->instance(AnnouncementService::class, $this->app->make(AnnouncementServiceProxy::class));
        $this->app->instance(LinkService::class, $this->app->make(LinkServiceProxy::class));
        $this->app->instance(SmsService::class, $this->app->make(SmsServiceProxy::class));
    }
}
