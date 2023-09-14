<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Constant\TableConstant;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;
use App\Models\AdministratorPermission;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class AdminPermissionBus
{
    protected $configService;

    public const PERMISSION_WHITE_LIST = [
        'user' => 1,
        'login' => 1,
        'dashboard' => 1,
        'dashboard/system/info' => 1,
        'dashboard/check' => 1,
        'role/all' => 1,
        'administrator_permission' => 1,
        'course/all' => 1,
        'upload/image/tinymce' => 1,
        'upload/image/download' => 1,
        'administrator/password' => 1,
    ];

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    public function inWhitelist(string $path): bool
    {
        return isset(self::PERMISSION_WHITE_LIST[$path]);
    }

    public function isSuperAdmin(int $adminId): bool
    {
        $roleIds = DB::table(TableConstant::TABLE_ADMIN_ROLE_RELATION)
            ->select(['role_id'])
            ->where('administrator_id', $adminId)
            ->get()
            ->pluck('role_id')
            ->toArray();
        if (!$roleIds) {
            return false;
        }

        return AdministratorRole::query()
            ->whereIn('id', $roleIds)
            ->where('slug', $this->configService->getSuperAdministratorSlug())
            ->exists();
    }

    public function hasPermission(int $adminId, string $path, string $method): bool
    {
        $method = strtoupper($method);

        $roleIds = DB::table(TableConstant::TABLE_ADMIN_ROLE_RELATION)
            ->select(['role_id'])
            ->where('administrator_id', $adminId)
            ->get()
            ->pluck('role_id')
            ->toArray();
        if (!$roleIds) {
            return false;
        }

        $permissionIds = DB::table(TableConstant::TABLE_ROLE_PERMISSION_RELATION)
            ->select(['permission_id'])
            ->whereIn('role_id', $roleIds)
            ->get()
            ->pluck('permission_id')
            ->toArray();
        if (!$permissionIds) {
            return false;
        }

        $permissions = AdministratorPermission::query()
            ->select(['url', 'method'])
            ->whereIn('id', $permissionIds)
            ->get()
            ->toArray();

        foreach ($permissions as $permissionItem) {
            $methods = explode('|', strtoupper($permissionItem['method']));
            if (preg_match("#${permissionItem['url']}#", $path) && in_array($method, $methods)) {
                return true;
            }
        }

        return false;
    }
}
