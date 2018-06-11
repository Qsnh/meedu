<?php

namespace App\Http\Requests\Backend\Administrator;

use Illuminate\Foundation\Http\FormRequest;

class AdministratorRequest extends FormRequest
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
            'name' => 'required|max:16',
            'email' => ['email'],
            'password' => 'required|min:6|max:16|confirmed',
        ];

        if ($this->isMethod('post')) {
            $rules['email'] = array_merge($rules['email'], ['required', 'unique:administrators']);
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
        $data = ['name' => $this->input('name', ''),];
        $this->input('password') && $data['password'] = bcrypt($this->input('password'));
        if ($this->isMethod('post')) {
            $data['email'] = $this->input('email');
        }
        return $data;
    }

}
