<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\Frontend;

use Illuminate\Support\Facades\Storage;
use App\Services\Base\Services\ConfigService;

class UploadImageRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'file' => 'required|image|size:2048',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => __('file.required'),
            'file.image' => __('file.image'),
            'file.size' => __('file.size', ['size' => '2M']),
        ];
    }

    public function filldata()
    {
        /**
         * @var ConfigService
         */
        $configService = app()->make(ConfigService::class);
        $disk = $configService->getDefaultStorageDisk();
        $path = $this->file('file')->store('images', compact('disk'));

        return [$path, Storage::disk($disk)->url($path)];
    }
}
