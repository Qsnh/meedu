<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class PromoCodeSaveMiddleware
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
        $promoCode = $request->input('promo_code', '');
        $promoCode && Cookie::queue('promo_code', $promoCode);
        return $next($request);
    }
}
