<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Api\V2\BaseController;

class SystemController extends BaseController
{
    /**
     * @api {get} /api/v3/status [V3]应用状态监测
     * @apiGroup 系统模块
     * @apiName SystemV3
     *
     * @apiSuccess {Number} code 0成功,非0失败
     */
    public function status()
    {
        return $this->success();
    }
}
