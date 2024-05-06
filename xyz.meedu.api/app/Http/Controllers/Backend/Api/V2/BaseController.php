<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V2;

class BaseController
{
    protected function success($message = '')
    {
        return response()->json([
            'status' => 0,
            'message' => $message,
            'data' => [],
        ]);
    }

    protected function successData($data = [], $message = '')
    {
        return response()->json([
            'status' => 0,
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function error($message, $code = 1)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => [],
        ]);
    }
}
