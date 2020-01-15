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

use App\Models\Administrator;
use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Backend\Administrator\EditPasswordRequest;
use App\Http\Requests\Backend\Administrator\AdministratorRequest;

class AdministratorController extends BaseController
{
    public function index()
    {
        $administrators = Administrator::orderByDesc('created_at')->paginate(request()->input('size', 12));

        return $this->successData($administrators);
    }

    public function store(
        AdministratorRequest $request,
        Administrator $administrator
    ) {
        $administrator->fill($request->filldata())->save();

        $administrator->roles()->sync($request->input('role_id', []));

        return $this->success();
    }

    public function edit($id)
    {
        $administrator = Administrator::findOrFail($id);

        return $this->successData($administrator);
    }

    public function update(AdministratorRequest $request, $id)
    {
        $administrator = Administrator::findOrFail($id);

        $administrator->fill($request->filldata())->save();

        $administrator->roles()->sync($request->input('role_id', []));

        return $this->success();
    }

    public function editPasswordHandle(EditPasswordRequest $request)
    {
        $administrator = Auth::guard(BackendApiConstant::GUARD)->user();
        if (
        !Hash::check(
            $request->input('old_password'),
            $administrator->password
        )
        ) {
            return $this->error(BackendApiConstant::OLD_PASSWORD_ERROR);
        }
        $administrator->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        $administrator = Administrator::findOrFail($id);
        if (!$administrator->couldDestroy()) {
            return $this->error(BackendApiConstant::ADMINISTRATOR_ACCOUNT_CANT_DELETE);
        }
        $administrator->delete();

        return $this->success();
    }
}
