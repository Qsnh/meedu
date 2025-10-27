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

        // 超级管理员拥有所有权限
        if ($this->bus->isSuperAdmin($admin['id'])) {
            return $next($request);
        }

        // 非超管情况下，如果是超管专属权限，直接拒绝
        if ($slug === BackendPermission::SUPER_ADMIN_ONLY) {
            return response()->json([
                'status' => 403,
                'message' => __('该功能仅限超级管理员访问'),
            ], 403);
        }

        // 检查管理员是否拥有该 slug 权限
        if ($this->bus->hasPermissionBySlug($admin['id'], $slug)) {
            return $next($request);
        }

        return response()->json([
            'status' => 403,
            'message' => __('无权限'),
        ], 403);
    }
}
