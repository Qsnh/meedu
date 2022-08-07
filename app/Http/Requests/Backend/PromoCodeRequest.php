<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

use App\Constant\TableConstant;

class PromoCodeRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'code' => 'required',
            'invited_user_reward' => 'required',
            'use_times' => 'required',
        ];

        $this->isMethod('post') && $rules['code'] .= '|unique:' . TableConstant::TABLE_PROMO_CODES;

        return $rules;
    }

    public function messages()
    {
        return [
            'code.required' => __('请输入优惠码'),
            'code.unique' => __('优惠码已存在'),
        ];
    }

    public function filldata()
    {
        $data = [
            'user_id' => 0,
            'expired_at' => $this->post('expired_at', null),
            'invite_user_reward' => (int)$this->post('invite_user_reward', 0),
            'invited_user_reward' => (int)$this->post('invited_user_reward', 0),
            'use_times' => (int)$this->post('use_times', 0),
        ];
        $this->isMethod('post') && $data['code'] = $this->input('code');
        return $data;
    }
}
