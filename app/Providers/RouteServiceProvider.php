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

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapWebBackendRoutes();
        $this->mapInstallRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'user.share'])
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    protected function mapWebBackendRoutes()
    {
        Route::prefix('backend')
            ->middleware(['web', 'user.share'])
            ->namespace($this->namespace.'\Backend')
            ->group(base_path('routes/web_backend.php'));
    }

    protected function mapInstallRoutes()
    {
        Route::prefix('install')
            ->middleware(['web', 'install.check'])
            ->namespace($this->namespace.'\Install')
            ->group(base_path('routes/install.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api/v1')
             ->middleware('api')
             ->namespace($this->namespace.'\Api\V1')
             ->group(base_path('routes/api.php'));
    }
}
