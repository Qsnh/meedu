<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
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
            'announcement' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'announcement.required' => '请输入公告内容',
        ];
    }

    public function filldata()
    {
        return [
            'announcement' => $this->input('announcement'),
        ];
    }

}
