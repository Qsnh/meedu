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

class SystemException extends \Exception
{
    use ResponseTrait;

    public function render()
    {
        if (request()->wantsJson()) {
            return $this->error(__('error'));
        }
        abort(500, $this->getMessage());
    }
}
