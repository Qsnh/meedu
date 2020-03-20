<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\Frontend\Member;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Frontend\BaseRequest;
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
         * @var $configService ConfigService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        $disk = $configService->getImageStorageDisk();
        $path = $this->file('file')->store($configService->getImageStoragePath(), compact('disk'));
        $url = Storage::disk($disk)->url($path);

        return compact('url');
    }
}
