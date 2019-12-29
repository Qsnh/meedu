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

class RegisterRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => 'required',
            'mobile_code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => __('mobile.required'),
            'mobile_code.required' => __('mobile_code.required'),
        ];
    }

    public function filldata()
    {
        return [
            'mobile' => $this->post('mobile'),
        ];
    }
}
