<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Requests\Frontend;

class CourseOrVideoCommentCreateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'content' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => __('请输入评论'),
            'content.min' => __('评论内容不能少于:count个字', ['count' => 6]),
        ];
    }

    public function filldata()
    {
        return ['content' => strip_tags(clean($this->post('content')))];
    }
}
