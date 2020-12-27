<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Middleware;

use Closure;
use App\Bus\AuthBus;
use App\Meedu\Wechat;
use App\Businesses\BusinessState;
use Illuminate\Support\Facades\Auth;

class WechatLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * @var AuthBus $bus
         */
        $bus = app()->make(AuthBus::class);
        /**
         * @var BusinessState $busState
         */
        $busState = app()->make(BusinessState::class);

        if (
            $busState->isEnabledMpOAuthLogin() &&
            is_h5() &&
            is_wechat() &&
            !Auth::check() &&
            !$request->has('skip_wechat')
        ) {
            // 指定token登录
            $bus->recordSocialiteTokenWay();

            // 跳转的url
            $redirectTo = $request->input('redirect');
            $redirectTo || $redirectTo = $request->fullUrl();
            $bus->recordSocialiteRedirectTo($redirectTo);

            // 登录平台
            $bus->recordSocialitePlatform();

            // 开始跳转到微信公众号授权登录
            return Wechat::getInstance()->oauth->redirect();
        }
        return $next($request);
    }
}
