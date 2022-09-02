<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Hooks;

use App\Bus\AuthBus;
use App\Meedu\Wechat;
use App\Bus\WechatScanBus;
use App\Meedu\Hooks\HookParams;
use App\Constant\FrontendConstant;
use App\Exceptions\ServiceException;
use App\Meedu\Hooks\HookRuntimeInterface;
use App\Meedu\ServiceV2\Services\UserService;
use App\Meedu\ServiceV2\Services\UserServiceInterface;

class MpWechatScanEvtSubHook implements HookRuntimeInterface
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
        if ($wechatScanBus->isLoginAction($eventKey) === false && $wechatScanBus->isBindAction($eventKey) === false) {
            return $next($params);
        }

        $openid = $params->getValue('FromUserName');
        // 通过openid获取微信用户信息[主要是为了unionId]
        $userData = (array)Wechat::getInstance()->user->get($openid);

        if ($wechatScanBus->isLoginAction($eventKey)) {
            /**
             * @var AuthBus $authBus
             */
            $authBus = app()->make(AuthBus::class);
            $loginUserId = $authBus->wechatLogin($openid, $userData['unionid'] ?? '', $userData);

            // 将userId写入到缓存
            $wechatScanBus->setLoginUserId($eventKey, $loginUserId);

            // 登录提示语
            if ($loginUserId === AuthBus::ERROR_CODE_BIND_MOBILE) {
                $params->setResponse(__('请绑定手机号'));
                // 将登录获取到的用户写入到缓存-将用于手机号绑定操作
                $wechatScanBus->setLoginUser($eventKey, $userData);
            } elseif ($loginUserId === 0) {
                $params->setResponse(__('系统错误'));
            } else {
                $params->setResponse(__('登录成功'));
            }
        } elseif ($wechatScanBus->isBindAction($eventKey)) {
            $bindUserId = $wechatScanBus->bindUserId($eventKey);
            if (!$bindUserId) {
                $params->setResponse(__('系统错误'));
            } else {
                try {
                    /**
                     * @var UserService $userService
                     */
                    $userService = app()->make(UserServiceInterface::class);
                    $userService->socialiteBind(
                        $bindUserId,
                        FrontendConstant::WECHAT_LOGIN_SIGN,
                        $openid,
                        $userData,
                        $userData['unionid'] ?? ''
                    );
                    $params->setResponse(__('已成功绑定当前微信账号'));
                } catch (ServiceException $e) {
                    $params->setResponse($e->getMessage());
                } catch (\Exception $e) {
                    exception_record($e);
                    $params->setResponse(__('系统错误'));
                }
            }
        }

        return $next($params);
    }
}
