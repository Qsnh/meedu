<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
            'name' => 'bail|required',
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
            'name.required' => __('请输入管理员昵称'),
            'email.required' => __('请输入邮箱'),
            'email.email' => __('请输入合法邮箱'),
            'email.unique' => __('邮箱已经存在'),
            'password.required' => __('请输入密码'),
            'password.min' => __('密码长度不能少于:size个字符', ['size' => 6]),
            'password.max' => __('密码长度不能多于:size个字符', ['size' => 16]),
            'password.confirmed' => __('两次输入密码不一致'),
        ];
    }

    /**
     * @return array
     */
    public function filldata()
    {
        $data = [
            'name' => $this->input('name'),
            'is_ban_login' => (int)$this->input('is_ban_login'),
        ];

        // 编辑
        $this->input('password') && $data['password'] = Hash::make($this->input('password'));
        if ($this->isMethod('post')) {
            $data['email'] = $this->input('email');
        }

        return $data;
    }
}
