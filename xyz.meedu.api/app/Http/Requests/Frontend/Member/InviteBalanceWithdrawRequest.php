<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Frontend\Member;

use App\Http\Requests\Frontend\BaseRequest;

class InviteBalanceWithdrawRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'total' => 'required',
            'channel' => 'required|array',
            'channel.name' => 'required',
            'channel.username' => 'required',
            'channel.account' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total.required' => __('请输入提现金额'),
            'channel.required' => __('请输入提现账户信息'),
            'channel.array' => __('请输入提现账户信息'),
            'channel.name.required' => __('请输入提现支付渠道'),
            'channel.username.required' => __('请输入提现支付渠道姓名'),
            'channel.account.required' => __('请输入提现支付渠道账号'),
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
