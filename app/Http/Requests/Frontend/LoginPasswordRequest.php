<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\Frontend;

class LoginPasswordRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => __('mobile.required'),
            'password.required' => __('password.required'),
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
