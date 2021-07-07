<?php

/*
 * This file is part of the Qsnh/meedu.
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
            'file' => 'bail|required|image',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => __('请上传文件'),
            'file.image' => __('请上传图片文件'),
        ];
    }

    /**
     * @return \Illuminate\Http\UploadedFile
     */
    public function filldata()
    {
        return $this->file('file');
    }
}
