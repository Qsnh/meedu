<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadRequest extends FormRequest
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
