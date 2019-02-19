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
            'mobile.required' => '请输入手机号',
            'password.required' => '请输入密码',
            'password.min' => '密码长度不能小于6个字符',
            'password.max' => '密码长度不能超过16个字符',
            'password.confirmed' => '两次输入的密码不一致',
        ];
    }
}
