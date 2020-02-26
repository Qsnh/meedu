<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\Backend\Administrator;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Backend\BaseRequest;

class EditPasswordRequest extends BaseRequest
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
            'old_password' => 'required',
            'new_password' => 'required|min:6|max:16|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => '请输入原密码',
            'new_password.required' => '请输入新密码',
            'new_password.min' => '新密码长度不能低于6个字符',
            'new_password.max' => '新密码长度不能超过16个字符',
            'new_password.confirmed' => '两次输入密码不一致',
        ];
    }

    /**
     * @return array
     */
    public function filldata()
    {
        return ['password' => Hash::make($this->input('new_password'))];
    }
}
