<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\AdministratorLoginSuccessEvent' => [
            'App\Listeners\AdministratorLoginSuccessListener',
        ],
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\Frontend\UserRegisterSuccess',
        ],
        'App\Events\AtUserEvent' => [
            'App\Listeners\AtUserListener',
        ],
        'App\Events\PaymentSuccessEvent' => [
            'App\Listeners\PaymentSuccessListener',
        ],
        'App\Events\AdFromEvent' => [
            'App\Listeners\AdFromListener',
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
