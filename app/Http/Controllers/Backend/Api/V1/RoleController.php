<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Arr;
use App\Models\AdministratorLog;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Http\Requests\Backend\RoleRequest;

class RoleController extends BaseController
{
    public function all()
    {
        $roles = Role::query()->get();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIP,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData(['data' => $roles]);
    }

    public function index()
    {
        $roles = Role::query()->orderByDesc('id')->paginate(request()->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIP,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData($roles);
    }

    public function store(RoleRequest $request)
    {
        $data = $request->filldata();

        Role::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIP,
            AdministratorLog::OPT_STORE,
            $data
        );

        return $this->success();
    }

    public function edit($id)
    {
        $role = Role::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIP,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($role);
    }

    public function update(RoleRequest $request, $id)
    {
        $data = $request->filldata();

        $role = Role::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_VIP,
            AdministratorLog::OPT_UPDATE,
            $data,
            Arr::only($role->toArray(), [
                'name', 'charge', 'expire_days', 'weight', 'description', 'is_show',
            ])
        );

        $role->fill($data)->save();

        return $this->success();
    }

    public function destroy($id)
    {
        if (User::query()->where('role_id', $id)->exists()) {
            return $this->error(__('当前VIP下存在用户无法删除'));
        }

        Role::destroy($id);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIP,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        return $this->success();
    }
}
