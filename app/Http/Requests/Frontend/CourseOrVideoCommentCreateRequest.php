<?php

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
            'content.required' => '请输入评论内容',
            'content.min' => '评论内容不能少于6个字',
        ];
    }

}
