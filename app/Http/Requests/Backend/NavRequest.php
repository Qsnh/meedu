<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
            'name' => 'required',
            'url' => 'required',
            'platform' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('请输入链接名'),
            'url.required' => __('请输入链接地址'),
            'platform.required' => __('请选择平台'),
        ];
    }

    public function filldata()
    {
        return [
            'parent_id' => (int)$this->input('parent_id'),
            'platform' => $this->input('platform'),
            'sort' => (int)$this->input('sort', 0),
            'name' => $this->input('name'),
            'url' => $this->input('url'),
            'active_routes' => $this->input('active_routes', '') ?: '',
            'blank' => (int)$this->input('blank'),
        ];
    }
}
