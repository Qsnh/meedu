<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
            'total' => 'required',
            'channel' => 'required',
            'channel_name' => 'required',
            'channel_account' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total.required' => __('请输入提现金额'),
            'channel.required' => __('请输入提现账户信息'),
            'channel_name.required' => __('请输入提现支付渠道姓名'),
            'channel_account.required' => __('请输入提现支付渠道账号'),
        ];
    }

    public function filldata()
    {
        return [
            'total' => (int)$this->post('total'),
            'channel' => [
                'name' => $this->input('channel'),
                'account' => $this->input('channel_account', '') ?? '',
                'address' => $this->input('channel_address', '') ?? '',
                'username' => $this->input('channel_name', '') ?? '',
            ],
        ];
    }
}
