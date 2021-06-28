<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\Frontend;

use Illuminate\Support\Str;

class RegisterPasswordRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => 'bail|required',
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
        $mobile = $this->input('mobile');
        $password = $this->input('password');

        $password = $password ? mb_substr($password, 0, 32) : Str::random(12);

        return [
            'mobile' => $mobile,
            'password' => $password,
        ];
    }
}
