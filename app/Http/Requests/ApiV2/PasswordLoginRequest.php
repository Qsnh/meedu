<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\ApiV2;

class PasswordLoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => 'bail|required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => '请输入手机号',
            'password.required' => '请输入密码',
        ];
    }

    public function filldata()
    {
        return [
            'mobile' => $this->post('mobile'),
            'password' => $this->post('password'),
        ];
    }
}
