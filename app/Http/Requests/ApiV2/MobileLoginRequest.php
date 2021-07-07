<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
