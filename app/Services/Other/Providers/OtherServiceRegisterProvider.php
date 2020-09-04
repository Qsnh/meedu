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
use App\Services\Other\Services\AdFromService;
use App\Services\Other\Services\UploadService;
use App\Services\Other\Proxies\NavServiceProxy;
use App\Services\Other\Proxies\SmsServiceProxy;
use App\Services\Other\Proxies\LinkServiceProxy;
use App\Services\Other\Services\MpWechatService;
use App\Services\Other\Proxies\SliderServiceProxy;
use App\Services\Other\Interfaces\NavServiceInterface;
use App\Services\Other\Interfaces\SmsServiceInterface;
use App\Services\Other\Interfaces\LinkServiceInterface;
use App\Services\Other\Proxies\IndexBannerServiceProxy;
use App\Services\Other\Proxies\AnnouncementServiceProxy;
use App\Services\Other\Interfaces\AdFromServiceInterface;
use App\Services\Other\Interfaces\SliderServiceInterface;
use App\Services\Other\Interfaces\UploadServiceInterface;
use App\Services\Other\Interfaces\MpWechatServiceInterface;
use App\Services\Other\Interfaces\IndexBannerServiceInterface;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;

class OtherServiceRegisterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance(AdFromServiceInterface::class, $this->app->make(AdFromService::class));
        $this->app->instance(NavServiceInterface::class, $this->app->make(NavServiceProxy::class));
        $this->app->instance(AnnouncementServiceInterface::class, $this->app->make(AnnouncementServiceProxy::class));
        $this->app->instance(LinkServiceInterface::class, $this->app->make(LinkServiceProxy::class));
        $this->app->instance(SmsServiceInterface::class, $this->app->make(SmsServiceProxy::class));
        $this->app->instance(UploadServiceInterface::class, $this->app->make(UploadService::class));
        $this->app->instance(IndexBannerServiceInterface::class, $this->app->make(IndexBannerServiceProxy::class));
        $this->app->instance(SliderServiceInterface::class, $this->app->make(SliderServiceProxy::class));
        $this->app->instance(MpWechatServiceInterface::class, $this->app->make(MpWechatService::class));
    }
}
