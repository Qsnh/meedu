<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\ApiV2;

class NicknameChangeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'nick_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nick_name.required' => __('nick_name.required'),
        ];
    }

    public function filldata()
    {
        return [
            'nick_name' => $this->post('nick_name'),
        ];
    }
}
