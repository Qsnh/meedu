<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Models\AdministratorLog;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\Log;
use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Backend\Administrator\EditPasswordRequest;
use App\Http\Requests\Backend\Administrator\AdministratorRequest;

class AdministratorController extends BaseController
{
    public function index(Request $request)
    {
        $administrators = Administrator::query()
            ->orderByDesc('id')
            ->paginate(request()->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR,
            AdministratorLog::OPT_VIEW,
            []
        );

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
        Administrator        $administrator
    ) {
        $data = $request->filldata();
        if (Administrator::query()->where('email', $data['email'])->exists()) {
            return $this->error(__('邮箱已经存在'));
        }

        $roleIds = $request->input('role_id', []);
        $administrator->fill($data)->save();
        $roleIds && $administrator->roles()->sync($roleIds);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR,
            AdministratorLog::OPT_STORE,
            array_merge(Arr::only($data, ['name', 'email', 'is_ban_login']), ['role_ids' => $roleIds])
        );

        return $this->success();
    }

    public function edit($id)
    {
        $administrator = Administrator::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($administrator);
    }

    public function update(AdministratorRequest $request, $id)
    {
        $administrator = Administrator::query()->where('id', $id)->firstOrFail();

        $data = $request->filldata();
        if (Administrator::query()->where('email', $data['email'])->where('id', '<>', $administrator['id'])->exists()) {
            return $this->error(__('邮箱已经存在'));
        }

        $roleIds = $request->input('role_id', []);
        $oldRoleIds = $administrator->roles()->select(['id'])->get()->pluck('id')->toArray();
        Log::info(__METHOD__, compact('oldRoleIds'));

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_ADMINISTRATOR,
            AdministratorLog::OPT_UPDATE,
            Arr::only(array_merge($data, ['role_ids' => $roleIds]), ['name', 'email', 'is_ban_login', 'role_ids']),
            Arr::only(array_merge($administrator->toArray(), ['role_ids' => $oldRoleIds]), ['name', 'email', 'is_ban_login', 'role_ids']),
            isset($data['password']) ? [__('更换密码')] : []
        );

        $administrator->fill($data)->save();
        $administrator->roles()->sync($roleIds);

        return $this->success();
    }

    public function editPasswordHandle(EditPasswordRequest $request)
    {
        $administrator = Auth::guard(BackendApiConstant::GUARD)->user();

        if (!Hash::check($request->input('old_password'), $administrator['password'])) {
            return $this->error(__('原密码错误'));
        }

        $administrator->fill($request->filldata())->save();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR,
            AdministratorLog::OPT_UPDATE,
            []
        );

        return $this->success();
    }

    public function destroy($id)
    {
        $administrator = Administrator::query()->where('id', $id)->firstOrFail();
        if ($administrator->couldDestroy()) {
            return $this->error(__('当前用户是超级管理员账户无法删除'));
        }
        $administrator->delete();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        return $this->success();
    }
}
