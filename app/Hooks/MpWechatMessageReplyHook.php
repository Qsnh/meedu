<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Hooks;

use App\Meedu\Hooks\HookParams;
use App\Meedu\Hooks\HookRuntimeInterface;
use App\Services\Other\Services\MpWechatService;
use App\Services\Other\Interfaces\MpWechatServiceInterface;

class MpWechatMessageReplyHook implements HookRuntimeInterface
{
    public const MSG_TYPE_TEXT = 'text';
    public const MSG_TYPE_EVENT = 'event';

    public function handle(HookParams $params, \Closure $next)
    {
        $types = [self::MSG_TYPE_TEXT => 1, self::MSG_TYPE_EVENT => 1];
        $msgType = $params->getValue('MsgType', '');
        if (!isset($types[$msgType])) {
            return $next($params);
        }

        /**
         * @var HookParams $response
         */
        $response = $next($params);
        if ($response) {
            // 如果已经有其它的中间件处理了该条消息并返回了值
            // 那么这里就不需要继续处理了
            // 当前中间件的权重是最低的
            return $response;
        }

        /**
         * @var MpWechatService $mpWechatService
         */
        $mpWechatService = app()->make(MpWechatServiceInterface::class);

        try {
            if ($msgType === self::MSG_TYPE_TEXT) {
                // 文本消息
                return $mpWechatService->textMessageReplyFind($params->getValue('raw.Content', ''));
            } elseif ($msgType === self::MSG_TYPE_EVENT) {
                // 事件消息
                $event = $params->getValue('raw.Event');
                $eventKey = $params->getValue('raw.EventKey');

                return $mpWechatService->eventMessageReplyFind($event, $eventKey);
            }
        } catch (\Exception $e) {
            exception_record($e);
        }
    }
}
