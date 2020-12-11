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

class NavRequest extends BaseRequest
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
            'sort' => 'required',
            'name' => 'required',
            'url' => 'required',
            'platform' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'sort.required' => '请输入排序值',
            'name.required' => '请输入链接名',
            'url.required' => '请输入链接地址',
            'platform.required' => '请选择平台',
        ];
    }

    public function filldata()
    {
        return [
            'parent_id' => (int)$this->input('parent_id'),
            'platform' => $this->input('platform'),
            'sort' => $this->input('sort'),
            'name' => $this->input('name'),
            'url' => $this->input('url'),
            'active_routes' => $this->input('active_routes', '') ?: '',
            'blank' => (int)$this->input('blank'),
        ];
    }
}
