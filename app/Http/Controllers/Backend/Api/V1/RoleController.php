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

use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Http\Requests\Backend\RoleRequest;

class RoleController extends BaseController
{
    public function all()
    {
        $roles = Role::query()->get();
        return $this->successData(['data' => $roles]);
    }

    public function index()
    {
        $roles = Role::orderByDesc('id')->paginate(request()->input('size', 12));

        return $this->successData($roles);
    }

    public function store(RoleRequest $request)
    {
        Role::create($request->filldata());

        return $this->success();
    }

    public function edit($id)
    {
        $info = Role::findOrFail($id);

        return $this->successData($info);
    }

    public function update(RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        if (User::query()->where('role_id', $id)->exists()) {
            return $this->error('有用户是该VIP，无法删除');
        }

        Role::destroy($id);

        return $this->success();
    }
}
