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
            'file.required' => '请上传头像',
            'file.image' => '请上传有效头像文件',
            'file.size' => '头像不能超过1M',
        ];
    }

    public function filldata()
    {
        $file = $this->file('file');
        $path = $file->store('/avatar');
        $url = Storage::disk(config('filesystems.default'))->url($path);

        return [$path, $url];
    }
}
