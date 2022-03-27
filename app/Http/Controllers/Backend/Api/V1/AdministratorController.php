<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\Administrator;
use App\Models\AdministratorRole;
use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Backend\Administrator\EditPasswordRequest;
use App\Http\Requests\Backend\Administrator\AdministratorRequest;

class AdministratorController extends BaseController
{
    public function index()
    {
        $administrators = Administrator::query()
            ->orderByDesc('id')
            ->paginate(request()->input('size', 10));

        return $this->successData($administrators);
    }

    public function create()
    {
        $roles = AdministratorRole::query()->select(['id', 'display_name'])->get();
        return $this->successData([
            'roles' => $roles,
        ]);
    }

    public function store(
        AdministratorRequest $request,
        Administrator $administrator
    ) {
        $data = $request->filldata();
        if (Administrator::query()->where('email', $data['email'])->exists()) {
            return $this->error(__('邮箱已经存在'));
        }

        $administrator->fill($data)->save();

        $administrator->roles()->sync($request->input('role_id', []));

        return $this->success();
    }

    public function edit($id)
    {
        $administrator = Administrator::query()->where('id', $id)->firstOrFail();

        return $this->successData($administrator);
    }

    public function update(AdministratorRequest $request, $id)
    {
        $administrator = Administrator::query()->where('id', $id)->firstOrFail();

        $data = $request->filldata();
        if (
            $data['email'] !== $administrator['email'] &&
            Administrator::query()->where('email', $data['email'])->where('id', '<>', $administrator['id'])->exists()
        ) {
            return $this->error(__('邮箱已经存在'));
        }

        $administrator->fill($data)->save();

        $administrator->roles()->sync($request->input('role_id', []));

        return $this->success();
    }

    public function editPasswordHandle(EditPasswordRequest $request)
    {
        $administrator = Auth::guard(BackendApiConstant::GUARD)->user();

        if (!Hash::check($request->input('old_password'), $administrator['password'])) {
            return $this->error(__('原密码错误'));
        }

        $administrator->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        $administrator = Administrator::query()->where('id', $id)->firstOrFail();
        if ($administrator->couldDestroy()) {
            return $this->error(__('当前用户是超级管理员账户无法删除'));
        }
        $administrator->delete();

        return $this->success();
    }
}
