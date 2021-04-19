<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Middleware;

use Closure;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;

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

            if ($bus->isNeedBindMobile(Auth::user()->toArray())) {
                return redirect(route('member.mobile.bind'));
            }
        }

        return $next($request);
    }
}
