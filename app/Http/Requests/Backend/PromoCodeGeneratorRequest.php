<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\Backend;

class PromoCodeGeneratorRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'prefix' => 'required',
            'num' => 'required',
            'money' => 'required',
            'expired_at' => 'required',
        ];
    }
}
