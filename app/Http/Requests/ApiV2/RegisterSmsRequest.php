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

class RegisterSmsRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => 'required',
            'mobile_code' => 'required',
            'password' => 'required|min:6|max:16',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => __('mobile.required'),
            'mobile_code.required' => __('please_input_mobile_code'),
            'password.required' => __('password.required'),
            'password.min' => __('password.min'),
            'password.max' => __('password.max'),
        ];
    }

    public function filldata()
    {
        return [
            'mobile' => $this->input('mobile'),
            'mobile_code' => $this->input('mobile_code'),
            'password' => $this->input('password'),
        ];
    }
}
