<?php

namespace App\Http\Requests\Frontend\Member;

use App\Http\Requests\Frontend\BaseRequest;
use Illuminate\Support\Facades\Storage;

class AvatarChangeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'file' => 'required|image|size:1024',
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
