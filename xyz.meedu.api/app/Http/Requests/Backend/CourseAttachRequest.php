<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\Backend;

class CourseAttachRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'key' => 'required',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'key.required' => __('参数错误'),
            'name.required' => __('请输入附件名'),
        ];
    }

    public function filldata()
    {
        return [
            'course_id' => (int)$this->post('course_id'),
            'name' => $this->post('name'),
            'key' => $this->post('key'),
        ];
    }
}
