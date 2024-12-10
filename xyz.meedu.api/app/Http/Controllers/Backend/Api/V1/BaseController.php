<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function adminId()
    {
        return Auth::guard('administrator')->id();
    }

    public function adminInfo()
    {
        return Auth::guard('administrator')->user();
    }

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
     * @param array $data
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
