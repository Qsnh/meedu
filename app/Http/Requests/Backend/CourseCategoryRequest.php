<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class CourseCategoryRequest extends BaseRequest
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
        ];
    }

    public function messages()
    {
        return [
            'sort.required' => __('请输入排序值'),
            'name.required' => __('请输入分类名'),
        ];
    }

    public function filldata()
    {
        return [
            'sort' => $this->input('sort'),
            'name' => $this->input('name'),
            'parent_id' => (int)$this->input('parent_id', 0),
            'is_show' => $this->input('is_show', 0),
        ];
    }
}
