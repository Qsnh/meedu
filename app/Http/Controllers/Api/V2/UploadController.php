<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Http\Requests\ApiV2\UploadImageRequest;

class UploadController extends BaseController
{
    public function image(UploadImageRequest $request)
    {
        $data = $request->filldata();
        return $this->data($data);
    }
}
