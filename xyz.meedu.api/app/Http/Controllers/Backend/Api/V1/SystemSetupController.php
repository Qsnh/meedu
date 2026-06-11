<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\Administrator;

class SystemSetupController extends BaseController
{
    public function status()
    {
        $needsInit = Administrator::query()->doesntExist();
        return $this->successData(['needs_init' => $needsInit]);
    }
}
