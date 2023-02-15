<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Api\V2\BaseController;

class SystemController extends BaseController
{
    public function status()
    {
        return $this->success();
    }
}
