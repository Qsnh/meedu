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

class BackendPermissionCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = admin();
        if ($admin->isSuper()) {
            return $next($request);
        }
        if (! $admin->couldVisited($request)) {
            if ($request->wantsJson()) {
                return response()->json(['code' => 401, 'message' => '无权限']);
            }
            flash('无权限', 'error');

            return back();
        }

        return $next($request);
    }
}
