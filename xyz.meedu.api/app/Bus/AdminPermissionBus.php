<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Constant\TableConstant;
use App\Meedu\Cache\MemoryCache;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;
use App\Constant\BackendApiConstant;
use App\Models\AdministratorPermission;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class AdminPermissionBus
{
    protected $configService;

    // API权限白名单
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

        // 获取管理员关联的角色表
        $roleIds = DB::table(TableConstant::TABLE_ADMIN_ROLE_RELATION)
            ->select(['role_id'])
            ->where('administrator_id', $adminId)
            ->get()
            ->pluck('role_id')
            ->toArray();
        if (!$roleIds) {
            return false;
        }

        // 获取角色的全部关联权限id数组
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

    public function hasDATAPermission(int $adminId, string $slug): bool
    {
        $permissionIds = $this->getAdminRelatingPermissionIds($adminId);

        return AdministratorPermission::query()
            ->whereIn('id', $permissionIds ?: [0])
            ->where('method', 'DATA')
            ->where('slug', $slug)
            ->exists();
    }

    public function hasDATAUserMobilePermission(int $adminId): bool
    {
        return $this->hasDATAPermission($adminId, BackendApiConstant::P_DATA_USER_MOBILE);
    }

    public function hasDATAUserRealNamePermission(int $adminId): bool
    {
        return $this->hasDATAPermission($adminId, BackendApiConstant::P_DATA_USER_REAL_NAME);
    }

    public function hasDATAUserIdNumberPermission(int $adminId): bool
    {
        return $this->hasDATAPermission($adminId, BackendApiConstant::P_DATA_USER_ID_NUMBER);
    }

    public function hasDATAAdministratorEmailPermission(int $adminId): bool
    {
        return $this->hasDATAPermission($adminId, BackendApiConstant::P_DATA_ADMINISTRATOR_EMAIL);
    }

    private function getAdminRelatingPermissionIds(int $adminId): array
    {
        $key = sprintf('admin_relating_permission_ids_%d', $adminId);
        $cache = MemoryCache::getInstance();
        if ($cache->exists($key)) {
            return $cache->get($key, []);
        }

        $data = call_user_func(function () use ($adminId) {
            // 获取管理员关联的角色表
            $roleIds = DB::table(TableConstant::TABLE_ADMIN_ROLE_RELATION)
                ->select(['role_id'])
                ->where('administrator_id', $adminId)
                ->get()
                ->pluck('role_id')
                ->toArray();
            if (!$roleIds) {
                return [];
            }

            $isSuperAdmin = AdministratorRole::query()
                ->whereIn('id', $roleIds)
                ->where('slug', $this->configService->getSuperAdministratorSlug())
                ->exists();
            if ($isSuperAdmin) {
                return AdministratorPermission::query()->select(['id'])->get()->pluck('id')->toArray();
            }

            // 获取角色的全部关联权限id数组
            return DB::table(TableConstant::TABLE_ROLE_PERMISSION_RELATION)
                ->select(['permission_id'])
                ->whereIn('role_id', $roleIds)
                ->get()
                ->pluck('permission_id')
                ->toArray();
        });

        $cache->set($key, $data);

        return $data;
    }
}
