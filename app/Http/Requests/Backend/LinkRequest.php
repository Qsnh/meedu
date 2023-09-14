<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('请输入友情链接名'),
        ];
    }

    public function filldata()
    {
        return [
            'sort' => (int)$this->input('sort', 0),
            'name' => $this->input('name'),
            'url' => $this->input('url') ?? '',
        ];
    }
}
