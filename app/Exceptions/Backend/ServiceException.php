<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Exceptions\Backend;

use Exception;

class ServiceException extends Exception
{
    public function render()
    {
        return response()->json([
            'status' => 500,
            'message' => $this->message,
        ]);
    }
}
