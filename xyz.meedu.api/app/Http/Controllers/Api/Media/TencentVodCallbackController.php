<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\Media;

use Illuminate\Http\Request;

class TencentVodCallbackController
{

    public function handler(Request $request, $sign)
    {
        // todo - 腾讯云点播回调处理
        return 'success';
    }

}
