<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware\Backend;

use Closure;
use Illuminate\Http\Request;
use App\Bus\AdminPermissionBus;
use App\Constant\BackendPermission;
use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;

class BackendPermissionCheckMiddleware
{
    protected $bus;

    public function __construct(AdminPermissionBus $bus)
    {
        $this->bus = $bus;
    }

    public function handle($request, Closure $next, ?string $slug = null)
    {
        /**
         * @var Request $request
         */

        // 如果没有传入 slug，说明路由配置有误
        if (!$slug) {
            return response()->json([
                'status' => 403,
                'message' => __('权限配置错误'),
            ], 403);
        }

        $admin = Auth::guard(BackendApiConstant::GUARD)->user();
        $adminId = (int)$admin['id'];

        if ($this->bus->canAccessBySlug($adminId, $slug)) {
            return $next($request);
        }

        // SUPER_ADMIN_ONLY 拒绝时给出更明确的提示
        if ($slug === BackendPermission::SUPER_ADMIN_ONLY) {
            return response()->json([
                'status' => 403,
                'message' => __('该功能仅限超级管理员访问'),
            ], 403);
        }

        return response()->json([
            'status' => 403,
            'message' => __('无权限'),
        ], 403);
    }
}
