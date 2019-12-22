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

class AvatarChangeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'file' => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => __('file.required'),
            'file.image' => __('file.image'),
            'file.size' => __('file.size', ['size' => '1M']),
        ];
    }

    public function filldata()
    {
        /**
         * @var ConfigService
         */
        $configService = app()->make(ConfigService::class);

        $file = $this->file('file');
        $path = $file->store('/avatar');
        $url = Storage::disk($configService->getDefaultStorageDisk())->url($path);

        return compact('path', 'url');
    }
}
