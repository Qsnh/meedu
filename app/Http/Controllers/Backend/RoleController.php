<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();
        return view('backend.role.index', compact('roles'));
    }

    public function create()
    {
        return view('backend.role.create');
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
        return view('backend.role.edit', compact('role'));
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
        $role = Role::findOrFail($id);
        if ($role->users()->exists()) {
            flash('该角色下面存在会员记录，无法删除');
        } else {
            $role->delete();
            flash('删除成功', 'success');
        }
        return back();
    }

}
