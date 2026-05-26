<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\ApiV2;

class AvatarChangeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'file' => 'bail|required|file|mimes:jpg,jpeg,png,gif,bmp,webp|mimetypes:image/jpeg,image/png,image/gif,image/bmp,image/webp|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => __('请上传文件'),
            'file.file' => __('请上传图片文件'),
            'file.mimes' => __('仅支持上传 jpg、jpeg、png、gif、bmp、webp 格式图片'),
            'file.mimetypes' => __('仅支持上传 jpg、jpeg、png、gif、bmp、webp 格式图片'),
            'file.max' => __('文件不能超过:size', ['size' => '1M']),
        ];
    }

    public function filldata()
    {
        return save_image($this->file('file'), 'avatar');
    }
}
