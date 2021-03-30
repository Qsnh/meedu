<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
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

    public function filldata()
    {
        return [
            'id' => $this->post('id'),
        ];
    }
}
