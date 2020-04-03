<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\Backend;

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

        $this->isMethod('post') && $rules['code'] .= '|unique:promo_codes';

        return $rules;
    }

    public function messages()
    {
        return [
            'code.required' => '请输入code',
            'code.unique' => 'code已存在',
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
