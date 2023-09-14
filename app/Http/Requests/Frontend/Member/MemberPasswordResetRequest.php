<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Frontend\Member;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Frontend\BaseRequest;
use App\Services\Member\Services\UserService;
use App\Services\Member\Interfaces\UserServiceInterface;

class MemberPasswordResetRequest extends BaseRequest
{
    public function rules()
    {
        $rules = [
            'new_password' => 'required|min:6|max:16|confirmed',
        ];
        /**
         * @var $userService UserService
         */
        $userService = app()->make(UserServiceInterface::class);
        $user = $userService->find(Auth::id());
        if ($user['is_password_set']) {
            $rules['old_password'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'old_password.required' => __('请输入原密码'),
            'new_password.required' => __('请输入新密码'),
            'new_password.min' => __('密码长度不能少于:size个字符', ['size' => 6]),
            'new_password.max' => __('密码长度不能多于:size个字符', ['size' => 16]),
            'new_password.confirmed' => __('两次输入密码不一致'),
        ];
    }

    public function filldata()
    {
        return [
            'old_password' => $this->input('old_password', ''),
            'new_password' => $this->input('new_password'),
        ];
    }
}
