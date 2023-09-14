<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Frontend\Member;

use App\Http\Requests\Frontend\BaseRequest;

class ReadAMessageRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => __('参数错误'),
        ];
    }

    public function filldata()
    {
        return [
            'id' => $this->post('id'),
        ];
    }
}
