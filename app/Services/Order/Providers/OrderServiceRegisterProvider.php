<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Order\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Order\Services\OrderService;
use App\Services\Order\Services\PromoCodeService;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;

class OrderServiceRegisterProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->instance(OrderServiceInterface::class, $this->app->make(OrderService::class));
        $this->app->instance(PromoCodeServiceInterface::class, $this->app->make(PromoCodeService::class));
    }
}
