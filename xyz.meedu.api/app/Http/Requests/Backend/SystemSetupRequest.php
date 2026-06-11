<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

use Illuminate\Support\Facades\Hash;

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
            'name.required' => __('请输入姓名'),
            'name.between' => __('姓名长度为 2-20 个字符'),
            'email.required' => __('请输入邮箱'),
            'email.email' => __('请输入合法邮箱'),
            'password.required' => __('请输入密码'),
            'password.between' => __('密码长度为 8-32 个字符'),
            'password.regex' => __('密码必须同时包含字母和数字'),
            'password.confirmed' => __('两次输入的密码不一致'),
        ];
    }

    public function filldata()
    {
        return [
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'password' => Hash::make($this->input('password')),
        ];
    }
}
