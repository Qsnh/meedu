<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class EmailSubscriptionRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '请输入邮件标题',
            'content.required' => '请输入邮件内容',
        ];
    }

    public function filldata()
    {
        return [
            $this->input('title'),
            (new \Parsedown)->text($this->input('content')),
        ];
    }
}
