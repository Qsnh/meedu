<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

use Carbon\Carbon;
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
            'avatar.required' => __('请上传头像'),
            'nick_name.required' => __('请输入昵称'),
            'nick_name.unique' => __('昵称已经存在'),
            'mobile.required' => __('请输入手机号'),
            'mobile.unique' => __('手机号已存在'),
            'password.required' => __('请输入密码'),
        ];
    }

    public function filldata()
    {
        $roleExpiredAt = $this->input('role_expired_at') ?: null;
        $roleExpiredAt && $roleExpiredAt = Carbon::parse($roleExpiredAt)->toDateTimeLocalString();

        return [
            'avatar' => $this->post('avatar'),
            'nick_name' => $this->post('nick_name'),
            'mobile' => $this->post('mobile'),
            'password' => Hash::make($this->post('password')),
            'is_active' => User::ACTIVE_YES,
            'role_id' => (int)$this->input('role_id'),
            'role_expired_at' => $roleExpiredAt,
        ];
    }
}
