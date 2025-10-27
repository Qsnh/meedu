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
use App\Constant\BackendPermission;
use App\Models\AdministratorPermission;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class AdminPermissionBus
{
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
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

    /**
     * 基于 slug 检查管理员是否拥有指定权限
     *
     * @param int $adminId
     * @param string $slug
     * @return bool
     */
    public function hasPermissionBySlug(int $adminId, string $slug): bool
    {
        $permissionIds = $this->getAdminRelatingPermissionIds($adminId);

        return AdministratorPermission::query()
            ->whereIn('id', $permissionIds ?: [0])
            ->where('slug', $slug)
            ->exists();
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
        return $this->hasDATAPermission($adminId, BackendPermission::DATA_USER_MOBILE);
    }

    public function hasDATAUserRealNamePermission(int $adminId): bool
    {
        return $this->hasDATAPermission($adminId, BackendPermission::DATA_USER_REAL_NAME);
    }

    public function hasDATAUserIdNumberPermission(int $adminId): bool
    {
        return $this->hasDATAPermission($adminId, BackendPermission::DATA_USER_ID_NUMBER);
    }

    public function hasDATAAdministratorEmailPermission(int $adminId): bool
    {
        return $this->hasDATAPermission($adminId, BackendPermission::DATA_ADMINISTRATOR_EMAIL);
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
