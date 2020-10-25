<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Backend\ImageUploadRequest;

class UploadController extends BaseController
{
    public function tinymceImageUpload(ImageUploadRequest $request)
    {
        $file = $request->filldata();
        $disk = config('meedu.upload.image.disk');
        $path = $file->store(config('meedu.upload.image.path'), $disk);
        $url = url(Storage::disk($disk)->url($path));

        return ['location' => $url, 'path' => $path];
    }

    public function imageUpload(Request $request)
    {
        return $this->error('function offline');
    }
}
