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

class AdministratorRequest extends BaseRequest
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
        $rules = [
            'name' => 'bail|required|max:16',
            'email' => ['bail', 'email'],
        ];

        if ($this->isMethod('post')) {
            $rules['email'] = array_merge($rules['email'], ['required', 'unique:administrators']);
            $rules['password'] = 'bail|required|min:6|max:16|confirmed';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '请输入姓名',
            'name.max' => '姓名长度不能超过16个字符',
            'email.required' => '请输入邮箱',
            'email.email' => '请输入合法邮箱',
            'email.unique' => '邮箱已经存在',
            'password.required' => '请输入密码',
            'password.min' => '密码长度不能小于6个字符',
            'password.max' => '密码长度不能超过16个字符',
            'password.confirmed' => '两次输入密码不一致',
        ];
    }

    /**
     * @return array
     */
    public function filldata()
    {
        $data = ['name' => $this->input('name', '')];
        $this->input('password') && $data['password'] = Hash::make($this->input('password'));
        if ($this->isMethod('post')) {
            $data['email'] = $this->input('email');
        }

        return $data;
    }
}
