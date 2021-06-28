<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Models\AdministratorRole;
use App\Models\AdministratorPermission;
use App\Http\Requests\Backend\AdministratorRoleRequest;

class AdministratorRoleController extends BaseController
{
    public function index(Request $request)
    {
        $roles = AdministratorRole::query()->orderByDesc('id')->paginate($request->input('size', 10));

        return $this->successData($roles);
    }

    public function create()
    {
        $permissions = AdministratorPermission::query()->select(['id', 'slug', 'display_name', 'group_name'])->get()->groupBy('group_name');
        return $this->successData([
            'permissions' => $permissions,
        ]);
    }

    public function store(
        AdministratorRoleRequest $request,
        AdministratorRole $role
    ) {
        $role->fill($request->filldata())->save();

        $role->permissions()->sync($request->input('permission_ids', []));

        return $this->success();
    }

    public function edit($id)
    {
        $role = AdministratorRole::query()->where('id', $id)->firstOrFail();

        return $this->successData($role);
    }

    public function update(AdministratorRoleRequest $request, $id)
    {
        $role = AdministratorRole::query()->where('id', $id)->firstOrFail();

        $role->fill($request->filldata())->save();

        $role->permissions()->sync($request->input('permission_ids', []));

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

        return $this->success();
    }
}
