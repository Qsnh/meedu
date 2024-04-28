<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class AdministratorRoleRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'display_name' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'display_name.required' => __('请输入后台管理角色名'),
            'description.required' => __('请输入后台管理角色描述'),
        ];
    }

    public function filldata()
    {
        return [
            'display_name' => $this->input('display_name'),
            'description' => $this->input('description'),
        ];
    }
}
