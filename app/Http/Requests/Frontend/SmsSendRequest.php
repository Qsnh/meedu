<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\Frontend;

use Illuminate\Validation\Rule;

class SmsSendRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'captcha' => 'required|captcha',
            'mobile' => 'required',
            'method' => ['required', Rule::in(['password_reset', 'register', 'mobile_bind', 'mobile_login'])],
        ];
    }

    public function messages()
    {
        return [
            'captcha.required' => __('请输入图形验证码'),
            'captcha.captcha' => __('图形验证码错误'),
            'mobile.required' => __('请输入手机号'),
            'method.*' => __('参数错误'),
        ];
    }

    public function filldata()
    {
        return [
            'mobile' => $this->input('mobile'),
            'method' => implode('', array_map('ucfirst', explode('_', $this->input('method')))),
        ];
    }
}
