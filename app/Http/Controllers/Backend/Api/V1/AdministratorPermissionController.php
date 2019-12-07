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

use App\Constant\BackendApiConstant;
use App\Models\AdministratorPermission;
use App\Http\Requests\Backend\AdministratorPermissionRequest;

class AdministratorPermissionController extends BaseController
{
    public function index()
    {
        $permissions = AdministratorPermission::orderByDesc('id')->paginate(10);

        return $this->successData($permissions);
    }

    public function store(
        AdministratorPermissionRequest $request,
        AdministratorPermission $permission
    ) {
        $permission->fill($request->filldata())->save();

        return $this->success();
    }

    public function edit($id)
    {
        $permission = AdministratorPermission::findOrFail($id);

        return $this->successData($permission);
    }

    public function update(AdministratorPermissionRequest $request, $id)
    {
        $permission = AdministratorPermission::findOrFail($id);
        $permission->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        $permission = AdministratorPermission::findOrFail($id);
        if ($permission->roles()->exists()) {
            return $this->error(BackendApiConstant::PERMISSION_BAN_DELETE_FOR_CHILDREN);
        }
        $permission->delete();

        return $this->success();
    }
}
