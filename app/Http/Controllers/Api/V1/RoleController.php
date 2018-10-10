<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\Role;
use App\Exceptions\ApiV1Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return RoleResource::collection($roles);
    }

    public function buyHandler(RoleRepository $repository, $role_id)
    {
        $role = Role::findOrFail($role_id);
        $user = Auth::user();

        if (! $repository->bulHandler($user, $role)) {
            throw new ApiV1Exception($repository->errors);
        }
    }
}
