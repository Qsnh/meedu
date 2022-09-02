<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Exceptions\Backend;

class ValidateException extends \Exception
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @codeCoverageIgnore
     */
    public function render()
    {
        return response()->json([
            'status' => 406,
            'message' => $this->message,
        ]);
    }
}
