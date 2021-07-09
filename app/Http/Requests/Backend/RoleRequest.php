<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class RoleRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'charge' => 'required',
            'expire_days' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('请输入VIP名'),
            'charge.required' => __('请输入VIP价格'),
            'expire_days.required' => __('请输入VIP有效时长'),
            'description.required' => __('请输入VIP介绍'),
        ];
    }

    public function filldata()
    {
        return [
            'name' => $this->input('name'),
            'charge' => (int)$this->input('charge'),
            'expire_days' => (int)$this->input('expire_days'),
            'weight' => (int)$this->input('weight'),
            'description' => $this->input('description'),
            'is_show' => (int)$this->input('is_show', 0),
        ];
    }
}
