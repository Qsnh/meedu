<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class BaseController extends Controller
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
