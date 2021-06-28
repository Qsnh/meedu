<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\Backend;

class LinkRequest extends BaseRequest
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
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('请输入友情链接名'),
            'url.required' => __('请输入友情链接地址'),
        ];
    }

    public function filldata()
    {
        return [
            'sort' => (int)$this->input('sort', 0),
            'name' => $this->input('name'),
            'url' => $this->input('url'),
        ];
    }
}
