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

class AdministratorPermissionRequest extends BaseRequest
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
            'method' => 'array',
        ];

        if ($this->isMethod('post')) {
            $rules['slug'] = 'required|unique:administrator_permissions';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'display_name.required' => '请输入权限名',
            'description.required' => '请输入权限描述',
            'slug.required' => '请输入Slug',
            'slug.unique' => 'Slug值已经存在',
            'method.array' => '数据格式错误',
        ];
    }

    public function filldata()
    {
        $data = [
            'display_name' => $this->input('display_name'),
            'description' => $this->input('description'),
            'method' => implode('|', $this->input('method', [])),
            'url' => $this->input('url', ''),
        ];

        if ($this->isMethod('post')) {
            $data['slug'] = $this->input('slug');
        }

        return $data;
    }
}
