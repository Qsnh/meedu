<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected function success($message = '')
    {
        return [
            'code' => 200,
            'message' => $message,
        ];
    }
}
