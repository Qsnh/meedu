<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\ApiV2;

class MobileLoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => __('请输入手机号'),
        ];
    }

    public function filldata()
    {
        return [
            'mobile' => $this->post('mobile'),
        ];
    }
}
