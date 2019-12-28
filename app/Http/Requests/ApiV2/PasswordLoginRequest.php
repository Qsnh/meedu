<?php


namespace App\Http\Requests\ApiV2;

class PasswordLoginRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'mobile' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => '请输入手机号',
            'password.required' => '请输入密码',
        ];
    }

    public function filldata()
    {
        return [
            'mobile' => $this->post('mobile'),
            'password' => $this->post('password'),
        ];
    }

}