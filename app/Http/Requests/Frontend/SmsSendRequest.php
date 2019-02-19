<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
            'method' => ['required', Rule::in(['password_reset', 'register'])],
        ];
    }

    public function messages()
    {
        return [
            'captcha.required' => '请输入验证码',
            'captcha.captcha' => '验证码错误',
            'mobile.required' => '请输入手机号',
            'method.*' => '参数错误',
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
