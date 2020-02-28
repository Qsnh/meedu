<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
            'old_password.required' => __('old_password.required'),
            'new_password.required' => __('new_password.required'),
            'new_password.min' => __('password.min'),
            'new_password.max' => __('password.max'),
            'new_password.confirmed' => __('password.confirmed'),
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
