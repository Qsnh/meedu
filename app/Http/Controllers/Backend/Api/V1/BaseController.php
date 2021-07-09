<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($message = '')
    {
        return response()->json([
            'status' => 0,
            'message' => $message,
            'data' => [],
        ]);
    }

    /**
     * @param array  $data
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successData($data = [], $message = '')
    {
        return response()->json([
            'status' => 0,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * @param $message
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message, $code = 1)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => [],
        ]);
    }
}
