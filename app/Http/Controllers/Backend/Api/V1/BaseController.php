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
