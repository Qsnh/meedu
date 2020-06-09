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

use Illuminate\Foundation\Http\FormRequest;

class InviteBalanceWithdrawRequest extends FormRequest
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
            'total' => 'required|integer',
            'channel' => 'required',
            'channel_name' => 'required',
            'channel_account' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total.required' => __('please input withdraw money'),
            'total.integer' => __('withdraw money must be integer'),
            'channel.required' => __('please input withdraw info'),
            'channel_name.required' => __('please select withdraw channel'),
            'channel_account.required' => __('please input withdraw account'),
        ];
    }

    public function filldata()
    {
        return [
            'total' => $this->post('total'),
            'channel' => [
                'name' => $this->input('channel'),
                'account' => $this->input('channel_account', '') ?? '',
                'address' => $this->input('channel_address', '') ?? '',
                'username' => $this->input('channel_name', '') ?? '',
            ],
        ];
    }
}
