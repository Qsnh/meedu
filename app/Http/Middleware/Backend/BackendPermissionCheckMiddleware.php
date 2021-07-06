<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Middleware\Backend;

use Closure;
use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;

class BackendPermissionCheckMiddleware
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
        $path = str_replace('backend/api/v1/', '', $request->path());
        // 白名单
        if (isset(BackendApiConstant::PERMISSION_WHITE_LIST[$path])) {
            return $next($request);
        }

        // 超级管理员
        $admin = Auth::guard(BackendApiConstant::GUARD)->user();
        if ((int)$admin['is_super'] === 1) {
            return $next($request);
        }

        // 权限判断
        if ($admin->hasPermission($path, $request->method())) {
            return $next($request);
        }

        return response()->json([
            'status' => 403,
            'message' => __('无权限'),
        ]);
    }
}
