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

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\RoleRequest;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderByDesc('weight')->get();

        return v('backend.role.index', compact('roles'));
    }

    public function create()
    {
        return v('backend.role.create');
    }

    public function store(RoleRequest $request)
    {
        Role::create($request->filldata());
        flash('添加成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return v('backend.role.edit', compact('role'));
    }

    public function update(RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        flash('角色无删除成功，如果真的需要删除请直接从数据库删除，但是请确保数据完整性！');

        return back();
    }
}
