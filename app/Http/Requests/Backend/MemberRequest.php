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

use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberRequest extends BaseRequest
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
            'avatar' => 'required',
            'nick_name' => 'required|unique:users,nick_name',
            'mobile' => 'required|unique:users,mobile',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'avatar.required' => '请上传头像',
            'nick_name.required' => '请输入昵称',
            'nick_name.unique' => '昵称已经存在',
            'mobile.required' => '请输入手机号',
            'mobile.unique' => '手机号已经存在',
            'password.required' => '请输入密码',
        ];
    }

    public function filldata()
    {
        return [
            'avatar' => $this->post('avatar'),
            'nick_name' => $this->post('nick_name'),
            'mobile' => $this->post('mobile'),
            'password' => Hash::make($this->post('password')),
            'is_active' => User::ACTIVE_YES,
            'role_id' => (int)$this->input('role_id'),
            'role_expired_at' => $this->input('role_expired_at') ?: null,
        ];
    }
}
