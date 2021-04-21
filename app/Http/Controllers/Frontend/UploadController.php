<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\UploadImageRequest;

class UploadController extends FrontendController
{
    public function imageHandler(UploadImageRequest $request)
    {
        ['path' => $path, 'url' => $url] = $request->filldata();
        $value = encrypt($url);

        return $this->data(compact('path', 'url', 'value'));
    }
}
