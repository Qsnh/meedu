<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Hooks;

use App\Bus\AuthBus;
use App\Meedu\Wechat;
use App\Bus\WechatBindBus;
use App\Constant\CacheConstant;
use App\Meedu\Hooks\HookParams;
use App\Exceptions\ServiceException;
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
         * @var WechatBindBus $wechatBindBus
         */
        $wechatBindBus = app()->make(WechatBindBus::class);

        if ($wechatBindBus->isBind($eventKey)) {
            // 微信公众号扫码绑定
            try {
                $wechatBindBus->handle($eventKey, $openid, (array)$userData);

                $params->setResponse(__('微信账号已成功绑定'));
            } catch (ServiceException $exception) {
                $params->setResponse($exception->getMessage());
            } catch (\Exception $exception) {
                exception_record($exception);
                $params->setResponse(__('系统错误'));
            }
            return $next($params);
        }


        // ------
        // 下面是微信公众号扫码登录逻辑
        // ------

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

        // 登录成功的回复语
        $params->setResponse(__('登录成功'));

        return $next($params);
    }
}
