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

use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Backend\ImageUploadRequest;

class UploadController extends BaseController
{
    public function tinymceImageUpload(ImageUploadRequest $request)
    {
        $file = $request->filldata();
        $disk = config('meedu.upload.image.disk');
        $path = $file->store(config('meedu.upload.image.path'), $disk);
        $url = Storage::disk($disk)->url($path);
        $disk == BackendApiConstant::LOCAL_PUBLIC_DISK && $url = rtrim(config('app.url'), '/') . $url;

        return ['location' => $url];
    }
}
