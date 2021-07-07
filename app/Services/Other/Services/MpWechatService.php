<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
     * @param mixed $eventKey
     * @return string
     */
    public function eventMessageReplyFind(string $event, $eventKey = ''): string
    {
        $messages = MpWechatMessageReply::query()
            ->where('type', MpWechatMessageReply::TYPE_EVENT)
            ->where('event_type', $event)
            ->orderByDesc('id')
            ->get();

        if ($messages->isEmpty()) {
            return '';
        }

        $content = '';

        if ($eventKey) {
            foreach ($messages as $message) {
                if (!$message['event_key']) {
                    continue;
                }

                if (preg_match('#' . $message['event_key'] . '#us', $eventKey)) {
                    $content = $message['reply_content'];
                    break;
                }
            }
        } else {
            foreach ($messages as $message) {
                if (!$message['event_key']) {
                    $content = $message['reply_content'];
                    break;
                }
            }
        }

        return $content;
    }
}
