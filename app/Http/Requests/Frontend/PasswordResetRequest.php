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
            'mobile.required' => __('mobile.required'),
            'password.required' => __('password.required'),
            'password.min' => __('password.min'),
            'password.max' => __('password.max'),
            'password.confirmed' => __('password.confirmed'),
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
