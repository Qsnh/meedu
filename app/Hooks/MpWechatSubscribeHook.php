<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Hooks;

use App\Bus\AuthBus;
use App\Meedu\Wechat;
use App\Constant\CacheConstant;
use App\Meedu\Hooks\HookParams;
use App\Meedu\Hooks\HookRuntimeInterface;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Interfaces\CacheServiceInterface;

class MpWechatSubscribeHook implements HookRuntimeInterface
{
    public function handle(HookParams $params, \Closure $next)
    {
        $msgType = $params->getValue('MsgType', '');
        $event = $params->getValue('raw.Event', '');

        if (!($msgType === 'event' && ($event === 'subscribe' || $event === 'SCAN'))) {
            return $next($params);
        }

        $eventKey = str_replace('qrscene_', '', $params->getValue('raw.EventKey'));
        if (!$eventKey) {
            // case: 直接关注event
            return $next($params);
        }

        $openid = $params->getValue('FromUserName');
        $userData = Wechat::getInstance()->user->get($openid);
        $unionId = $userData['unionid'] ?? '';

        /**
         * @var AuthBus $authBus
         */
        $authBus = app()->make(AuthBus::class);

        $userId = $authBus->wechatLogin($openid, $unionId, (array)$userData);

        // 写入到缓存
        /**
         * @var CacheService $cacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);

        $cacheService->put(
            get_cache_key(CacheConstant::WECHAT_SCAN_LOGIN['name'], $eventKey),
            $userId,
            CacheConstant::WECHAT_SCAN_LOGIN['expire']
        );

        return $next($params);
    }
}
