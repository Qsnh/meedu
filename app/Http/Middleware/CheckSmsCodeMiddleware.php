<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Middleware;

use Closure;

class CheckSmsCodeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sessionKey = 'sms_' . $request->post('sms_captcha_key', '');
        $captcha = (string)session($sessionKey);
        if (!$captcha || $captcha !== $request->post('sms_captcha', '')) {
            if ($request->wantsJson()) {
                return response()->json([
                    'code' => 1,
                    'message' => __('mobile code error'),
                ]);
            }
            flash(__('mobile code error'));

            return back();
        }
        session()->forget($sessionKey);

        return $next($request);
    }
}
