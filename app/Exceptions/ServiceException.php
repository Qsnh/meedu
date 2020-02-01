<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Exceptions;

use App\Http\Controllers\Api\V2\Traits\ResponseTrait;

class ServiceException extends \Exception
{
    use ResponseTrait;

    public function render()
    {
        $message = $this->getMessage();
        if (request()->wantsJson()) {
            return $this->error($message);
        }
        flash($message);

        return back();
    }
}
