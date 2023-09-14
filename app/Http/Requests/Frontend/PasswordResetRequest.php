<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Frontend;

class PasswordResetRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => 'required',
            'password' => 'required|min:6|max:16|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => __('请输入手机号'),
            'password.required' => __('请输入密码'),
            'password.min' => __('密码长度不能少于:size个字符', ['size' => 6]),
            'password.max' => __('密码长度不能多于:size个字符', ['size' => 16]),
            'password.confirmed' => __('两次输入密码不一致'),
        ];
    }

    public function filldata()
    {
        return [
            'mobile' => $this->input('mobile'),
            'password' => $this->input('password'),
        ];
    }
}
