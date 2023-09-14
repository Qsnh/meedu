<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Exceptions;

use App\Http\Controllers\Api\V2\Traits\ResponseTrait;

class ApiV2Exception extends \Exception
{
    use ResponseTrait;


    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @codeCoverageIgnore
     */
    public function render()
    {
        return $this->error($this->getMessage());
    }
}
