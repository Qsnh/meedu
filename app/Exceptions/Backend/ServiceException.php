<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Exceptions\Backend;

use Exception;

class ServiceException extends Exception
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @codeCoverageIgnore
     */
    public function render()
    {
        return response()->json([
            'status' => 500,
            'message' => $this->message,
        ]);
    }
}
