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
use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;

class BackendPermissionCheckMiddleware
{
    protected $bus;

    public function __construct(AdminPermissionBus $bus)
    {
        $this->bus = $bus;
    }

    public function handle($request, Closure $next)
    {
        /**
         * @var Request $request
         */

        $path = str_replace(['backend/api/v1/', 'backend/api/v2/'], '', $request->path());

        $admin = Auth::guard(BackendApiConstant::GUARD)->user();

        if (
            $this->bus->inWhitelist($path) ||
            $this->bus->isSuperAdmin($admin['id']) ||
            $this->bus->hasPermission($admin['id'], $path, $request->method())
        ) {
            return $next($request);
        }

        return response()->json([
            'status' => 403,
            'message' => __('无权限'),
        ]);
    }
}
