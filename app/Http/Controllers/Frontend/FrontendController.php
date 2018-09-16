<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;

class FrontendController extends BaseController
{
    protected function success($message = '', $data = [])
    {
        return [
            'code' => 200,
            'message' => $message,
            'data' => $data,
        ];
    }
}
