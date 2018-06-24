<?php

namespace App\Listeners;

use App\Events\AdministratorLoginSuccessEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdministratorLoginSuccessListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdministratorLoginSuccessEvent  $event
     * @return void
     */
    public function handle(AdministratorLoginSuccessEvent $event)
    {
        $administrator = $event->administrator;

        $administrator->last_login_ip = request()->getClientIp();
        $administrator->last_login_date = date('Y-m-d H:i:s');
        $administrator->save();
    }
}
