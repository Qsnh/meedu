<?php

namespace App\Http\Requests\Frontend\Member;

use App\Http\Requests\Frontend\BaseRequest;

class MemberPasswordResetRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:6|max:16|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => '请输入原密码',
            'new_password.required' => '请输入新密码',
            'new_password.min' => '密码长度不能小于6个字符',
            'new_password.max' => '密码长度不能超过16个字符',
            'new_password.confirmed' => '两次输入的密码不一致',
        ];
    }

    public function filldata()
    {
        return [
            $this->input('old_password'),
            $this->input('new_password'),
        ];
    }

}
