<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ImageUploadRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
