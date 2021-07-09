<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
