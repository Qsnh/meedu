<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Http\Requests\Backend\ImageUploadRequest;

class UploadController extends BaseController
{
    public function tinymceImageUpload(ImageUploadRequest $request)
    {
        $file = $request->filldata();
        $data = save_image($file);

        return ['location' => $data['url'], 'path' => $data['path']];
    }

    public function imageUpload()
    {
        return $this->error('function offline');
    }
}
