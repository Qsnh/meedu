<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2\Traits;

trait ResponseTrait
{
    protected function success($code = 0, $message = '', $data = [])
    {
        return $this->response($code, $message, $data);
    }

    protected function error($message, $code = 1, $data = [])
    {
        return $this->response($code, $message, $data);
    }

    protected function data($data = [], $code = 0, $message = '')
    {
        return $this->response($code, $message, $data);
    }

    protected function response($code, $message, $data)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
