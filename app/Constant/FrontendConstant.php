<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Constant;

class FrontendConstant
{
    const RENDER_MARKDOWN = 'markdown';
    const RENDER_HTML = 'html';

    const PAYMENT_SCENE_PC = 'pc';
    const PAYMENT_SCENE_WECHAT_MINI = 'wechat_mini';
    const PAYMENT_SCENE_H5 = 'h5';
    const PAYMENT_SCENE_WECHAT_OPEN = 'wechat';

    const ORDER_PAID = 9;

    const YES = 1;

    const H5 = 'h5';

    const ORDER_PAID_TYPE_PROMO_CODE = 1;

    const INVITE_BALANCE_WITHDRAW_STATUS_SUCCESS = 1;
    const INVITE_BALANCE_WITHDRAW_STATUS_FAILURE = 2;

    // 登录跳转url存储key
    const LOGIN_CALLBACK_URL_KEY = 'login_callback_url';
    // 社交登录用户信息临时存储key
    const SOCIALITE_USER_INFO_KEY = 'socialite_login_user_data';

    // 登录跳转白名单
    const LOGIN_REFERER_BLACKLIST = [
        '/register',
        '/password/reset',
    ];

    const PASSWORD_SET = 1;

    const ORDER_GOODS_TYPE_COURSE = 'COURSE';
    const ORDER_GOODS_TYPE_VIDEO = 'VIDEO';
    const ORDER_GOODS_TYPE_ROLE = 'ROLE';

    const API_GUARD = 'apiv2';

    public const CREDIT1_REMARK_REGISTER = 'credit1_remark_register';
    public const CREDIT1_REMARK_WATCHED_COURSE = 'credit1_remark_watched_course';
    public const CREDIT1_REMARK_WATCHED_VIDEO = 'credit1_remark_watched_video';
    public const CREDIT1_REMARK_WATCHED_ORDER = 'credit1_remark_order';
    public const CREDIT1_REMARK_WATCHED_INVITE = 'credit1_remark_invite';
    public const CREDIT1_REMARK_WATCHED_OTHER = 'credit1_remark_other';

    public const PLAYER_XG = 'xg';
    public const PLAYER_TENCENT = 'tencent';
    public const PLAYER_ALIYUN = 'aliyun';

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

    // 微信小程序登录socialite sign
    public const WECHAT_MINI_LOGIN_SIGN = 'WECHAT-MINI';
}
