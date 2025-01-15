<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class MediaVideoCategoryRequest extends BaseRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('请输入分类名'),
        ];
    }

    public function filldata()
    {
        return [
            'name' => $this->input('name'),
            'sort' => (int)$this->input('sort'),
            'parent_id' => (int)$this->input('parent_id'),
        ];
    }

}
