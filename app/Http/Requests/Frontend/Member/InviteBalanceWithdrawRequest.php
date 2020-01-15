<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\Frontend\Member;

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
            'channel' => 'required|array',
            'channel.name' => 'required',
            'channel.username' => 'required',
            'channel.account' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total.required' => __('please input withdraw money'),
            'total.integer' => __('withdraw money must be integer'),
            'channel.required' => __('please input withdraw info'),
            'channel.array' => __('please input withdraw info'),
            'channel.name.required' => __('please select withdraw channel'),
            'channel.username.required' => __('please input withdraw username'),
            'channel.account.required' => __('please input withdraw account'),
        ];
    }

    public function filldata()
    {
        return [
            'total' => $this->post('total'),
            'channel' => [
                'name' => $this->input('channel.name'),
                'account' => $this->input('channel.account'),
                'address' => $this->input('channel.address') ?? '',
                'username' => $this->input('channel.username'),
            ],
        ];
    }
}
