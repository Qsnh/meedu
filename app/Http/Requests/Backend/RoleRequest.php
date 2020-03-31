<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\Backend;

class RoleRequest extends BaseRequest
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
            'name' => 'required',
            'charge' => 'required',
            'expire_days' => 'required',
            'weight' => 'required',
            'description' => 'required',
        ];
    }

    public function filldata()
    {
        return [
            'name' => $this->input('name'),
            'charge' => $this->input('charge'),
            'expire_days' => $this->input('expire_days'),
            'weight' => $this->input('weight'),
            'description' => $this->input('description'),
            'is_show' => $this->input('is_show', 0),
        ];
    }
}
