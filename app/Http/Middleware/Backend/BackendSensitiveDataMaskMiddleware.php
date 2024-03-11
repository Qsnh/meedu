<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware\Backend;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Bus\AdminPermissionBus;
use Illuminate\Http\JsonResponse;
use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;
use App\Meedu\Utils\SensitiveDataMask;

class BackendSensitiveDataMaskMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /**
         * @var Response $response
         */
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            /**
             * @var AdminPermissionBus $permissionBus
             */
            $permissionBus = app()->make(AdminPermissionBus::class);

            $adminId = Auth::guard(BackendApiConstant::GUARD)->id();
            $data = $response->getData(true);

            if (!$permissionBus->hasDATAUserMobilePermission($adminId)) {
                $data = SensitiveDataMask::valueMask($data, 'mobile');
            }
            if (!$permissionBus->hasDATAUserRealNamePermission($adminId)) {
                $data = SensitiveDataMask::valueMask($data, 'real_name');
            }
            if (!$permissionBus->hasDATAUserIdNumberPermission($adminId)) {
                $data = SensitiveDataMask::valueMask($data, 'id_number');
            }

            $response->setData($data);
        }

        return $response;
    }
}
