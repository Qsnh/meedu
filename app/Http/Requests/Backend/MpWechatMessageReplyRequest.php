<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
            'type.required' => __('请选择消息类型'),
            'reply_content.required' => __('请输入回复内容'),
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
