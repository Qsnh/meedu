<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class PromoCodeGeneratorRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'prefix' => 'required',
            'num' => 'required',
            'money' => 'required',
            'expired_at' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'prefix.required' => __('请输入优惠码前缀'),
            'num.required' => __('请输入生成优惠码数量'),
            'money.required' => __('请输入优惠码面值'),
            'expired_at.required' => __('请输入优惠码过期时间'),
        ];
    }
}
