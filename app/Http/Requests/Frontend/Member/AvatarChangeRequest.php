<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Frontend\Member;

use App\Http\Requests\Frontend\BaseRequest;

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
            'file.required' => __('请上传文件'),
            'file.image' => __('请上传图片文件'),
            'file.max' => __('文件不能超过:size', ['size' => '1M']),
        ];
    }

    public function filldata()
    {
        return save_image($this->file('file'));
    }
}
