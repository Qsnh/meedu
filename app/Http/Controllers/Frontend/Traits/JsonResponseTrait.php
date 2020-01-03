<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend\Traits;

use App\Constant\FrontendConstant;

trait JsonResponseTrait
{
    public function jsonError($message)
    {
        return response()->json([
            'code' => FrontendConstant::JSON_ERROR_CODE,
            'message' => $message,
        ]);
    }

    public function jsonSuccess($data = [])
    {
        return response()->json([
            'code' => 0,
            'data' => $data,
        ]);
    }
}
