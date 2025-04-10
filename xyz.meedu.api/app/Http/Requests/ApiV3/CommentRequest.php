<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Requests\ApiV3;

use App\Http\Requests\ApiV2\BaseRequest;

class CommentRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'rt' => 'required|integer',
            'rid' => 'required|integer',
            'content' => 'required|max:140',
        ];
    }

    public function messages()
    {
        return [
            'rt.required' => __('参数错误'),
            'rt.integer' => __('参数错误'),
            'rid.required' => __('参数错误'),
            'rid.integer' => __('参数错误'),
            'content.required' => __('请输入评论内容'),
            'content.max' => __('评论内容最多140个字符'),
        ];
    }

    public function filldata()
    {
        return [
            'rt' => max(1, $this->post('rt')),
            'rid' => max(1, $this->post('rid')),
            'parent_id' => $this->post('parent_id'),
            'reply_id' => $this->post('reply_id'),
            'content' => strip_tags($this->post('content')),
        ];
    }

}
