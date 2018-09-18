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

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Backend\ImageUploadRequest;

class UploadController extends Controller
{
    public function uploadImageHandle(ImageUploadRequest $request)
    {
        $file = $request->filldata();
        $path = $file->store(config('meedu.upload.image.path'), config('meedu.upload.image.disk'));
        $url = Storage::disk(config('meedu.upload.image.disk'))->url($path);

        return ['path' => $path, 'url' => $url];
    }
}
