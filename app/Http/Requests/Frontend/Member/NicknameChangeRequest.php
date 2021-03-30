<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\Frontend\Member;

use App\Http\Requests\Frontend\BaseRequest;

class NicknameChangeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'nick_name' => 'required|max:10',
        ];
    }

    public function messages()
    {
        return [
            'nick_name.required' => __('nick_name.required'),
            'nick_name.max' => __('nick_name.max', ['max' => 10]),
        ];
    }

    public function filldata()
    {
        return [
            'nick_name' => $this->post('nick_name'),
        ];
    }
}
