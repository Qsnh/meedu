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

use Illuminate\Foundation\Http\FormRequest;

class AdFromRequest extends FormRequest
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
        'from_name' => 'required',
'from_key' => 'required',
        ];
    }

    public function messages()
    {
        return [
        'from_name.required' => '请输入推广链接名',
'from_key.required' => '请输入推广链接特征值',
        ];
    }

    public function filldata()
    {
        return [
        'from_name' => $this->input('from_name'),
'from_key' => $this->input('from_key'),
        ];
    }
}
