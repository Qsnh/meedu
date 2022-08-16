<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\ApiV3;

use App\Http\Requests\ApiV2\BaseRequest;

class SocialiteLoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            's_url' => 'required|max:255',
            'f_url' => 'required|max:255',
            'action' => 'required|in:login,bind',
        ];
    }

    public function messages()
    {
        return [
            's_url.required' => __('参数错误'),
            's_url.size' => __('参数错误'),
            'f_url.required' => __('参数错误'),
            'f_url.size' => __('参数错误'),
            'action.required' => __('参数错误'),
            'action.in' => __('参数错误'),
        ];
    }
}
