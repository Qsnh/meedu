<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoUploadController extends Controller
{
    public function aliyun(Request $request)
    {
        $token = $request->input('token', '');
        if (! $token) {
            exit('ban');
        }

        return view('backend.video.upload.aliyun', compact('token'));
    }

    public function tencent(Request $request)
    {
        $token = $request->input('token', '');
        if (! $token) {
            exit('ban');
        }

        return view('backend.video.upload.tencent', compact('token'));
    }
}
