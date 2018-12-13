<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdministratorPermission;
use App\Http\Requests\Backend\AdministratorPermissionRequest;

class AdministratorPermissionController extends Controller
{
    public function index()
    {
        $permissions = AdministratorPermission::paginate(10);

        return view('backend.administrator_permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('backend.administrator_permission.create');
    }

    public function store(
        AdministratorPermissionRequest $request,
        AdministratorPermission $permission
    ) {
        $permission->fill($request->filldata())->save();
        flash('添加成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $permission = AdministratorPermission::findOrFail($id);

        return view('backend.administrator_permission.edit', compact('permission'));
    }

    public function update(AdministratorPermissionRequest $request, $id)
    {
        $permission = AdministratorPermission::findOrFail($id);
        $permission->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        $permission = AdministratorPermission::findOrFail($id);
        if ($permission->roles()->exists()) {
            flash('该权限下还有角色，请先删除该角色');
        } else {
            $permission->delete();
            flash('删除成功', 'success');
        }

        return back();
    }
}
