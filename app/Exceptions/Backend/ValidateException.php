<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Exceptions\Backend;

class ValidateException extends \Exception
{
    public function render()
    {
        return response()->json([
            'status' => 406,
            'message' => $this->message,
        ]);
    }
}
