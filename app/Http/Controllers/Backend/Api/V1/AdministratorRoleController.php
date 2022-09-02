<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Models\AdministratorRole;
use App\Models\AdministratorPermission;
use App\Http\Requests\Backend\AdministratorRoleRequest;

class AdministratorRoleController extends BaseController
{
    public function index(Request $request)
    {
        $roles = AdministratorRole::query()->orderByDesc('id')->paginate($request->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR_ROLE,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData($roles);
    }

    public function create()
    {
        $permissions = AdministratorPermission::query()
            ->select(['id', 'slug', 'display_name', 'group_name'])
            ->get()
            ->groupBy('group_name')
            ->toArray();

        return $this->successData([
            'permissions' => $permissions,
        ]);
    }

    public function store(
        AdministratorRoleRequest $request,
        AdministratorRole        $role
    ) {
        $data = $request->filldata();
        $permissionIds = $request->input('permission_ids', []);

        $role->fill($data)->save();
        $permissionIds && $role->permissions()->sync($permissionIds);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR_ROLE,
            AdministratorLog::OPT_STORE,
            array_merge($data, ['permission_ids' => $permissionIds])
        );

        return $this->success();
    }

    public function edit($id)
    {
        $role = AdministratorRole::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR_ROLE,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($role);
    }

    public function update(AdministratorRoleRequest $request, $id)
    {
        $role = AdministratorRole::query()->where('id', $id)->firstOrFail();

        $data = $request->filldata();
        $permissionIds = $request->input('permission_ids', []);

        $oldPermissionIds = $role->permissions()->select(['id'])->get()->pluck('id')->toArray();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_ADMINISTRATOR_ROLE,
            AdministratorLog::OPT_UPDATE,
            Arr::only(array_merge($data, ['permission_ids' => $permissionIds]), ['display_name', 'slug', 'description', 'permission_ids']),
            Arr::only(array_merge($role->toArray(), ['permission_id' => $oldPermissionIds]), ['display_name', 'slug', 'description', 'permission_ids'])
        );

        $role->fill($data)->save();
        $role->permissions()->sync($permissionIds);

        return $this->success();
    }

    public function destroy($id)
    {
        $role = AdministratorRole::query()->where('id', $id)->firstOrFail();

        if ($role->administrators()->exists()) {
            return $this->error(__('请先取消与该角色绑定的管理员'));
        }

        if ($role['slug'] === config('meedu.administrator.super_slug')) {
            return $this->error(__('当前用户是超级管理员账户无法删除'));
        }

        $role->delete();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR_ROLE,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        return $this->success();
    }
}
