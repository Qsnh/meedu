<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Models\AdministratorRole;
use App\Constant\BackendApiConstant;
use App\Http\Requests\Backend\AdministratorRoleRequest;

class AdministratorRoleController extends BaseController
{
    public function index()
    {
        $roles = AdministratorRole::orderByDesc('id')->paginate(\request()->input('size', 12));

        return $this->successData($roles);
    }

    public function store(
        AdministratorRoleRequest $request,
        AdministratorRole $role
    ) {
        $role->fill($request->filldata())->save();

        return $this->success();
    }

    public function edit($id)
    {
        $role = AdministratorRole::findOrFail($id);

        return $this->successData($role);
    }

    public function update(AdministratorRoleRequest $request, $id)
    {
        $role = AdministratorRole::findOrFail($id);
        $role->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        $role = AdministratorRole::findOrFail($id);
        if ($role->administrators()->exists()) {
            return $this->error(BackendApiConstant::ROLE_BAN_DELETE_FOR_ADMINISTRATOR);
        }
        if ($role->slug === config('meedu.administrator.super_slug')) {
            return $this->error(BackendApiConstant::ROLE_BAN_DELETE_FOR_INIT_ADMINISTRATOR);
        }
        $role->delete();

        return $this->success();
    }

    public function permissionSave(Request $request, $id)
    {
        $role = AdministratorRole::findOrFail($id);
        $role->permissions()->sync($request->input('permission_id', []));

        return $this->success();
    }
}
