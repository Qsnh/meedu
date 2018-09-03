<?php

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
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
