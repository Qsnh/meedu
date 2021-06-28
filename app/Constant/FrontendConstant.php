<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Constant;

class FrontendConstant
{
    const PAYMENT_SCENE_PC = 'pc';
    const PAYMENT_SCENE_WECHAT_MINI = 'wechat_mini';
    const PAYMENT_SCENE_H5 = 'h5';
    const PAYMENT_SCENE_WECHAT_OPEN = 'wechat';

    // 订单已支付
    const ORDER_PAID = 9;

    const INVITE_BALANCE_WITHDRAW_STATUS_SUCCESS = 1;
    const INVITE_BALANCE_WITHDRAW_STATUS_FAILURE = 2;

    // 登录跳转url存储key
    const LOGIN_CALLBACK_URL_KEY = 'login_callback_url';

    // api会员认证driver
    const API_GUARD = 'apiv2';

    public const LOGIN_PLATFORM_PC = 'PC';
    public const LOGIN_PLATFORM_H5 = 'H5';
    public const LOGIN_PLATFORM_IOS = 'IOS';
    public const LOGIN_PLATFORM_ANDROID = 'ANDROID';
    public const LOGIN_PLATFORM_MINI = 'MINI';
    public const LOGIN_PLATFORM_APP = 'APP';
    public const LOGIN_PLATFORM_OTHER = 'OTHER';

    public const USER_LOGIN_AT_COOKIE_NAME = 'last_login_at';

    // 不限制
    public const LOGIN_LIMIT_RULE_DEFAULT = 1;
    // 每个平台允许登录一台设备已登录
    public const LOGIN_LIMIT_RULE_PLATFORM = 2;
    // 所有平台只允许一台设备已登录
    public const LOGIN_LIMIT_RULE_ALL = 3;

    // 幻灯片设备
    public const SLIDER_PLATFORM_PC = 'PC';
    public const SLIDER_PLATFORM_H5 = 'H5';
    public const SLIDER_PLATFORM_MINI = 'MINI';
    public const SLIDER_PLATFORM_APP = 'APP';

    // 导航栏平台
    public const NAV_PLATFORM_PC = 'PC';
    public const NAV_PLATFORM_H5 = 'h5';

    // 微信小程序登录sign
    public const WECHAT_MINI_LOGIN_SIGN = 'WECHAT-MINI';

    // 微信公众号登录sign
    public const WECHAT_LOGIN_SIGN = 'wechat';

    // 手机号强制绑定路由检测白名单
    public const MOBILE_BIND_ROUTE_WHITELIST = [
        'member.mobile.bind',
        'member.mobile.bind.submit',
        'logout',
    ];
}
