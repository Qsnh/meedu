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

use App\Models\AdministratorPermission;

class AdministratorPermissionController extends BaseController
{
    public function index()
    {
        $permissions = AdministratorPermission::query()->orderByDesc('id')->get();

        return $this->successData($permissions);
    }
}
