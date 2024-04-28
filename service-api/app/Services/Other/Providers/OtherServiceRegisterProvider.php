<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Other\Services\NavService;
use App\Services\Other\Services\SmsService;
use App\Services\Other\Services\LinkService;
use App\Services\Other\Services\SliderService;
use App\Services\Other\Services\MpWechatService;
use App\Services\Other\Services\ViewBlockService;
use App\Services\Other\Services\AnnouncementService;
use App\Services\Other\Services\SearchRecordService;
use App\Services\Other\Interfaces\NavServiceInterface;
use App\Services\Other\Interfaces\SmsServiceInterface;
use App\Services\Other\Interfaces\LinkServiceInterface;
use App\Services\Other\Interfaces\SliderServiceInterface;
use App\Services\Other\Interfaces\MpWechatServiceInterface;
use App\Services\Other\Interfaces\ViewBlockServiceInterface;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;
use App\Services\Other\Interfaces\SearchRecordServiceInterface;

class OtherServiceRegisterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance(NavServiceInterface::class, $this->app->make(NavService::class));
        $this->app->instance(AnnouncementServiceInterface::class, $this->app->make(AnnouncementService::class));
        $this->app->instance(LinkServiceInterface::class, $this->app->make(LinkService::class));
        $this->app->instance(SmsServiceInterface::class, $this->app->make(SmsService::class));
        $this->app->instance(SliderServiceInterface::class, $this->app->make(SliderService::class));
        $this->app->instance(MpWechatServiceInterface::class, $this->app->make(MpWechatService::class));
        $this->app->instance(ViewBlockServiceInterface::class, $this->app->make(ViewBlockService::class));
        $this->app->instance(SearchRecordServiceInterface::class, $this->app->make(SearchRecordService::class));
    }
}
