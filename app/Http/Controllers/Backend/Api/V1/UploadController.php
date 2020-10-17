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

use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
        $disk === BackendApiConstant::LOCAL_PUBLIC_DISK && $url = rtrim(config('app.url'), '/') . $url;

        return ['location' => $url];
    }

    public function imageUpload(Request $request)
    {
        return $this->error('function offline');
//        $url = $request->input('url');
//        if (!$url) {
//            return $this->error('请输入图片地址');
//        }
//        $extension = '';
//        if (preg_match('/\.png/i', $url)) {
//            $extension = 'png';
//        } elseif (preg_match('/\.jpg/i', $url)) {
//            $extension = 'jpg';
//        } elseif (preg_match('/\.gif/i', $url)) {
//            $extension = 'gif';
//        } elseif (preg_match('/\.jpeg/i', $url)) {
//            $extension = 'jpeg';
//        }
//        if (!$extension) {
//            return $this->error('无法检测图片格式');
//        }
//
//        try {
//            // 将图片保存到本地临时文件
//            $content = file_get_contents($url);
//            $tmpPath = config('meedu.upload.image.path') . '/' . Str::random(32) . '.' . $extension;
//
//            // 保存到storage
//            $disk = config('meedu.upload.image.disk');
//            Storage::disk($disk)->put($tmpPath, $content);
//            $url = url(Storage::disk($disk)->url($tmpPath));
//
//            return $this->successData([
//                'path' => $tmpPath,
//                'url' => $url,
//            ]);
//        } catch (\Exception $e) {
//            return $this->error($e->getMessage());
//        }
    }
}
