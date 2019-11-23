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

class AdministratorMenuRequest extends BaseRequest
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
            'permission_id' => 'required',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'permission_id.required' => '请选择权限',
            'name.required' => '请输入链接名',
            'url.required' => '请输入链接地址',
        ];
    }

    public function filldata()
    {
        return [
            'parent_id' => $this->post('parent_id', 0),
            'order' => $this->post('order', 1),
            'permission_id' => $this->post('permission_id'),
            'name' => $this->post('name'),
            'url' => $this->post('url'),
        ];
    }
}
