<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Middleware;

use Closure;
use App\Businesses\BusinessState;
use Illuminate\Support\Facades\Auth;

class WechatLoginMiddleware
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
        /**
         * @var BusinessState $busState
         */
        $busState = app()->make(BusinessState::class);

        if (
            $busState->isEnabledMpOAuthLogin() &&
            is_h5() &&
            is_wechat() &&
            !Auth::check() &&
            !$request->has('skip_wechat')
        ) {
            $redirect = $request->fullUrl();
            return redirect(route('login.wechat.oauth') . '?redirect=' . $redirect);
        }
        return $next($request);
    }
}
