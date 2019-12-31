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

class RegisterPasswordRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'nick_name' => 'required|max:10',
            'mobile' => 'bail|required',
            'password' => 'bail|required|min:6|max:16|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'nick_name.required' => __('nick_name.required'),
            'nick_name.max' => __('nick_name.max', ['max' => 10]),
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
            'nick_name' => $this->post('nick_name'),
            'mobile' => $this->post('mobile'),
            'password' => $this->post('password'),
        ];
    }
}
