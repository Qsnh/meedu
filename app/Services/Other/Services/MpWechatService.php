<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Other\Services;

use App\Services\Other\Models\MpWechatMessageReply;
use App\Services\Other\Interfaces\MpWechatServiceInterface;

class MpWechatService implements MpWechatServiceInterface
{

    /**
     * 获取文本消息匹配的回复内容
     * @param string $text
     * @return string
     */
    public function textMessageReplyFind(string $text): string
    {
        $messages = MpWechatMessageReply::query()->where('type', MpWechatMessageReply::TYPE_TEXT)->select(['id', 'rule'])->get();
        $id = 0;
        foreach ($messages as $message) {
            $rule = $message['rule'] ?? '';
            if (!$rule) {
                continue;
            }

            if (preg_match('#' . $rule . '#', $text)) {
                $id = $message['id'];
                break;
            }
        }

        $message = MpWechatMessageReply::query()->where('id', $id)->first();
        return $message['reply_content'] ?? '';
    }

    /**
     * 获取事件的回复内容
     * @param string $event
     * @param string $eventKey
     * @return string
     */
    public function eventMessageReplyFind(string $event, string $eventKey = ''): string
    {
        $message = MpWechatMessageReply::query()
            ->where('type', MpWechatMessageReply::TYPE_EVENT)
            ->where('event_type', $event)
            ->when($eventKey, function ($query) use ($eventKey) {
                $query->where('event_key', $eventKey);
            })
            ->first();
        if (!$message) {
            return '';
        }
        return $message['reply_content'] ?? '';
    }
}
