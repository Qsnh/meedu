<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
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
            'sort' => 'required',
            'name' => 'required',
            'course_ids' => 'required|array',
        ];
    }

    public function filldata()
    {
        return [
            'sort' => $this->input('sort'),
            'name' => $this->input('name'),
            'course_ids' => implode(',', $this->input('course_ids')),
        ];
    }
}
