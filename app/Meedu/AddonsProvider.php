<?php

namespace App\Meedu;

use Illuminate\Contracts\Foundation\Application;

class AddonsProvider
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        (new \App\Meedu\Addons)->serviceProviderLoad($app);
    }
}
