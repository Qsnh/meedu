<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\Backend;

class EmailSubscriptionRequest extends BaseRequest
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
            'content' => 'required',
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
            (new \Parsedown())->text($this->input('content')),
        ];
    }
}
