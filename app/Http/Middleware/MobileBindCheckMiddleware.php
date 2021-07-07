<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware;

use Closure;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class MobileBindCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->routeIs(FrontendConstant::MOBILE_BIND_ROUTE_WHITELIST)) {
            /**
             * @var BusinessState $bus
             */
            $bus = app()->make(BusinessState::class);

            /**
             * @var ConfigService $configService
             */
            $configService = app()->make(ConfigServiceInterface::class);

            if ($configService->getEnabledMobileBindAlert() && $bus->isNeedBindMobile(Auth::user()->toArray())) {
                return redirect(route('member.mobile.bind'));
            }
        }

        return $next($request);
    }
}
