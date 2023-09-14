<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\ApiV2;

class CommentRequest extends BaseRequest
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
