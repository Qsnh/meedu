<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Frontend\Member;

use App\Http\Requests\Frontend\BaseRequest;

class NicknameChangeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'nick_name' => 'required|min:3|max:12',
        ];
    }

    public function messages()
    {
        return [
            'nick_name.required' => __('请输入昵称'),
            'nick_name.max' => __('昵称不能多于:size个字', ['max' => 12]),
            'nick_name.min' => __('昵称不能少于:size个字', ['max' => 3]),
        ];
    }

    public function filldata()
    {
        return [
            'nick_name' => $this->post('nick_name'),
        ];
    }
}
