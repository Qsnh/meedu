<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\AdministratorRoleRequest;
use App\Models\AdministratorRole;
use App\Http\Controllers\Controller;

class AdministratorRoleController extends Controller
{

    public function index()
    {
        $roles = AdministratorRole::paginate(10);
        return view('backend.administrator_role.index', compact('roles'));
    }

    public function create()
    {
        return view('backend.administrator_role.create');
    }

    public function store(
        AdministratorRoleRequest $request,
        AdministratorRole $role
    )
    {
        $role->fill($request->filldata())->save();
        flash('角色添加成功', 'success');
        return back();
    }

    public function edit($id)
    {
        $role = AdministratorRole::findOrFail($id);
        return view('backend.administrator_role.edit', compact('role'));
    }

    public function update(AdministratorRoleRequest $request, $id)
    {
        $role = AdministratorRole::findOrFail($id);
        $role->fill($request->filldata())->save();
        flash('角色编辑成功', 'success');
        return back();
    }

    public function destroy($id)
    {
        $role = AdministratorRole::findOrFail($id);
        if ($role->administrators()->exists()) {
            flash('该角色下还存在管理员，请先删除相应的管理员');
        } else {
            $role->delete();
            flash('删除成功', 'success');
        }
        return back();
    }

}
