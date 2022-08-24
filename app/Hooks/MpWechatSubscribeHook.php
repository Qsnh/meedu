<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Hooks;

use App\Bus\AuthBus;
use App\Meedu\Wechat;
use App\Bus\WechatBindBus;
use App\Bus\WechatScanBus;
use App\Constant\CacheConstant;
use App\Meedu\Hooks\HookParams;
use App\Exceptions\ServiceException;
use App\Meedu\Hooks\HookRuntimeInterface;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

// @Deprecated
class MpWechatSubscribeHook implements HookRuntimeInterface
{
    public function handle(HookParams $params, \Closure $next)
    {
        $msgType = $params->getValue('MsgType', '');
        $event = $params->getValue('raw.Event', '');

        // 仅订阅subscribe,SCAN事件
        if (!($msgType === 'event' && ($event === 'subscribe' || $event === 'SCAN'))) {
            return $next($params);
        }

        // 剔除`qrscene_`这个前缀,剩余的字符串就是自定义二维码携带的自定义参数
        $eventKey = str_replace('qrscene_', '', $params->getValue('raw.EventKey'));
        if (!$eventKey) {
            // case: 直接关注公众号event
            return $next($params);
        }

        /**
         * @var WechatScanBus $wechatScanBus
         */
        $wechatScanBus = app()->make(WechatScanBus::class);
        if ($wechatScanBus->isLoginAction($eventKey) || $wechatScanBus->isBindAction($eventKey)) {
            // v2-handler
            return $next($params);
        }

        $openid = $params->getValue('FromUserName');
        // 通过openid获取微信用户信息
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

        /**
         * @var ConfigService $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);
        $replyContent = $configService->getMpWechatScanLoginAlert() ?? '';

        // 登录成功的回复语
        $params->setResponse($replyContent);

        return $next($params);
    }
}
