<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class AdministratorRoleRequest extends BaseRequest
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
            'display_name' => 'required',
            'description' => 'required',
        ];

        if ($this->isMethod('post')) {
            $rules['slug'] = 'required|unique:administrator_roles';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'display_name.required' => __('请输入后台管理角色名'),
            'slug.required' => __('请输入后台管理角色slug'),
            'slug.unique' => __('后台管理角色slug已存在'),
            'description.required' => __('请输入后台管理角色描述'),
        ];
    }

    public function filldata()
    {
        $data = [
            'display_name' => $this->input('display_name'),
            'description' => $this->input('description'),
        ];

        if ($this->isMethod('post')) {
            $data['slug'] = $this->input('slug');
        }

        return $data;
    }
}
