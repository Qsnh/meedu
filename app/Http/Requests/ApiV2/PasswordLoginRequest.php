<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
            'mobile.required' => __('请输入手机号'),
            'password.required' => __('请输入密码'),
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
