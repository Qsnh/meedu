<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\Backend;

class MpWechatMessageReplyRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'type' => 'required',
            'reply_content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '请选择消息类型',
            'reply_content.required' => '请输入回复内容',
        ];
    }

    public function filldata()
    {
        return [
            'type' => $this->input('type'),
            'event_type' => $this->input('event_type') ?? '',
            'event_key' => $this->input('event_key') ?? '',
            'rule' => $this->input('rule') ?? '',
            'reply_content' => $this->input('reply_content') ?? '',
        ];
    }
}
