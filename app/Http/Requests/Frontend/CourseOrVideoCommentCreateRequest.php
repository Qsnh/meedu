<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
            'content.required' => __('comment.content.required'),
            'content.min' => __('comment.content.min', ['count' => 6]),
        ];
    }

    public function filldata()
    {
        return ['content' => $this->post('content')];
    }
}
