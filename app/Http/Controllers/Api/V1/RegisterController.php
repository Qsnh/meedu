<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V1;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\RegisterRequest;

class RegisterController extends Controller
{
    public function handler(RegisterRequest $request, User $user)
    {
        $user->fill($request->filldata())->save();
    }
}
