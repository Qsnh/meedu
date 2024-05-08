<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\AdministratorPermission;

class AdministratorPermissionController extends BaseController
{
    public function index()
    {
        $permissions = AdministratorPermission::query()->orderByDesc('id')->get();

        return $this->successData($permissions);
    }
}
