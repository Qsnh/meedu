<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class SystemSetupRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'bail|required|string|between:2,20',
            'email' => 'bail|required|email|max:100',
            'password' => 'bail|required|string|between:8,32|regex:/^(?=.*[A-Za-z])(?=.*\d).+$/|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入姓名',
            'name.between' => '姓名长度为 2-20 个字符',
            'email.required' => '请输入邮箱',
            'email.email' => '请输入合法邮箱',
            'password.required' => '请输入密码',
            'password.between' => '密码长度为 8-32 个字符',
            'password.regex' => '密码必须同时包含字母和数字',
            'password.confirmed' => '两次输入的密码不一致',
        ];
    }

    public function filldata()
    {
        return [
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'password' => \Illuminate\Support\Facades\Hash::make($this->input('password')),
        ];
    }
}
