<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
