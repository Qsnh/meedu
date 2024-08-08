<?php

/*
 * This file is part of the MeEdu.
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
        $this->mapFrontendRoutes();
        $this->mapFrontendV2Routes();
        $this->mapFrontendV3Routes();
        $this->mapWebRoutes();
        $this->mapBackendApiV1Routes();
        $this->mapBackendApiV2Routes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web'])
            ->namespace('App\Http\Controllers\Frontend')
            ->group(base_path('routes/web.php'));
    }

    protected function mapFrontendV2Routes()
    {
        Route::prefix('/api/v2')
            ->middleware('api')
            ->namespace($this->namespace . '\Api\V2')
            ->group(base_path('routes/frontend-v2.php'));
    }

    protected function mapFrontendV3Routes()
    {
        Route::prefix('/api/v3')
            ->middleware('api')
            ->namespace($this->namespace . '\Api\V3')
            ->group(base_path('routes/frontend-v3.php'));
    }

    protected function mapFrontendRoutes()
    {
        Route::prefix('/api')
            ->middleware('api')
            ->namespace($this->namespace.'\Api')
            ->group(base_path('routes/frontend.php'));
    }

    protected function mapBackendApiV1Routes()
    {
        Route::prefix('/backend/api/v1')
            ->middleware(['api'])
            ->namespace($this->namespace . '\Backend\Api\V1')
            ->group(base_path('routes/backend-v1.php'));
    }

    protected function mapBackendApiV2Routes()
    {
        Route::prefix('/backend/api/v2')
            ->middleware(['api'])
            ->namespace($this->namespace . '\Backend\Api\V2')
            ->group(base_path('routes/backend-v2.php'));
    }
}
