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

class ApiV2Exception extends \Exception
{
    use ResponseTrait;

    public function render()
    {
        return $this->error($this->getMessage());
    }
}
