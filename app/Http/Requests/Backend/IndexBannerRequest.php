<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class IndexBannerRequest extends BaseRequest
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
            'course_ids' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('请输入banner名'),
            'course_ids.required' => __('请选择课程'),
            'course_ids.array' => __('请选择课程'),
        ];
    }

    public function filldata()
    {
        return [
            'sort' => (int)$this->input('sort', 0),
            'name' => $this->input('name'),
            'course_ids' => implode(',', $this->input('course_ids')),
        ];
    }
}
