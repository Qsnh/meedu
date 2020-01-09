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
        return [
            'code' => 'required|unique:promo_codes',
            'invited_user_reward' => 'required',
            'use_times' => 'required',
        ];
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
        return [
            'user_id' => 0,
            'code' => $this->post('code'),
            'expired_at' => $this->post('expired_at', null),
            'invite_user_reward' => intval($this->post('invite_user_reward', 0)),
            'invited_user_reward' => $this->post('invited_user_reward'),
            'use_times' => $this->post('use_times'),
        ];
    }
}
