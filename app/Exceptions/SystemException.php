<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Exceptions;

use App\Http\Controllers\Api\V2\Traits\ResponseTrait;

class SystemException extends \Exception
{
    use ResponseTrait;

    /**
     * @return \Illuminate\Http\JsonResponse|void
     *
     * @codeCoverageIgnore
     */
    public function render()
    {
        if (request()->wantsJson()) {
            return $this->error(__('错误'));
        }
        abort(500, $this->getMessage());
    }
}
