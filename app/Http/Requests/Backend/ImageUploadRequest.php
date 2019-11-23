<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
            'file.required' => '请上传图片',
            'file.image' => '请上传有效图片',
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
