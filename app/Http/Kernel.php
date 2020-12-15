<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http;

use Fruitcake\Cors\HandleCors;
use App\Http\Middleware\GlobalShareMiddleware;
use App\Http\Middleware\WechatLoginMiddleware;
use App\Http\Middleware\CheckSmsCodeMiddleware;
use App\Http\Middleware\PromoCodeSaveMiddleware;
use App\Http\Middleware\LoginStatusCheckMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\BackendPermissionCheckMiddleware;

class Kernel extends HttpKernel
{
    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \App\Meedu\AddonsProvider::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
//        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
        HandleCors::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            PromoCodeSaveMiddleware::class,
        ],

        'api' => [
            'throttle:120,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // global变量共享
        'global.share' => GlobalShareMiddleware::class,
        // 短信验证
        'sms.check' => CheckSmsCodeMiddleware::class,
        // 后台权限
        'backend.permission' => BackendPermissionCheckMiddleware::class,
        // 登录状态检测
        'login.status.check' => LoginStatusCheckMiddleware::class,
        // api接口的状态登录检测
        'api.login.status.check' => \App\Http\Middleware\Api\LoginStatusCheckMiddleware::class,
        // 微信公众号授权登录[微信浏览器里]
        'wechat.login' => WechatLoginMiddleware::class,
    ];
}
