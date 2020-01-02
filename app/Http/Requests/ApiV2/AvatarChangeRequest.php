<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\ApiV2;

use Illuminate\Support\Facades\Storage;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class AvatarChangeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'file' => 'required|image|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => __('file.required'),
            'file.image' => __('file.image'),
            'file.max' => __('file.max', ['size' => '1M']),
        ];
    }

    public function filldata()
    {
        /**
         * @var ConfigService
         */
        $configService = app()->make(ConfigServiceInterface::class);
        $path = $this->file('file')->store($configService->getImageStoragePath(), [
            'disk' => $configService->getImageStorageDisk(),
        ]);

        return [
            'path' => $path,
            'url' => Storage::disk($configService->getImageStorageDisk())->url($path),
        ];
    }
}
