<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class ImageUploadRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'bail|required|file|mimes:jpg,jpeg,png,gif,bmp,webp|mimetypes:image/jpeg,image/png,image/gif,image/bmp,image/webp',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => __('请上传文件'),
            'file.file' => __('请上传图片文件'),
            'file.mimes' => __('仅支持上传 jpg、jpeg、png、gif、bmp、webp 格式图片'),
            'file.mimetypes' => __('仅支持上传 jpg、jpeg、png、gif、bmp、webp 格式图片'),
        ];
    }

    public function filldata(): array
    {
        return [
            'file' => $this->file('file'),
            'scene' => $this->input('scene') ?? '',
        ];
    }
}
