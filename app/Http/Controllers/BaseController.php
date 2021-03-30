<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;

class BaseController extends Controller
{
    use ResponseTrait;

    /**
     * @return int|null
     */
    public function id()
    {
        return Auth::id();
    }

    public function check()
    {
        return Auth::check();
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return Auth::user()->toArray();
    }
}
