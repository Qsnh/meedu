<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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

        // 路由中出现{id}的必须为整数
        Route::pattern('id', '\d+');
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapApiV2Routes();
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapBackendApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'global.share'])
            ->namespace('App\Http\Controllers\Frontend')
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiV2Routes()
    {
        Route::prefix('/api/v2')
            ->middleware('api')
            ->namespace($this->namespace . '\Api\V2')
            ->group(base_path('routes/apiv2.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('/api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapBackendApiRoutes()
    {
        Route::prefix('/backend/api/v1')
            ->middleware(['api'])
            ->namespace($this->namespace . '\Backend\Api\V1')
            ->group(base_path('routes/backend-api.php'));
    }
}
