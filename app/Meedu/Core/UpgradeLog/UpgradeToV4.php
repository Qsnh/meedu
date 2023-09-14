<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Models\AdministratorMenu;
use App\Services\Base\Model\AppConfig;

class UpgradeToV4
{
    public static function handle()
    {
        self::removeConfig();

        self::removeAdminMenu();
    }

    public static function removeConfig()
    {
        // 删除缓存配置
        // 缓存配置给用户带来了极大的困扰，很多用户因为开启了缓存导致一些问题的出现
        // 但是ta们并不认为这是开启缓存导致的
        // 而认为是程序的问题
        AppConfig::query()
            ->whereIn('key', [
                'meedu.system.cache.status',
                'meedu.system.cache.expire',
            ])
            ->delete();

        // 删除github登录
        // 现在大陆服务器访问github经常出现超时的情况
        // 已经严重影响了用户体验
        // 删除微信web扫码登录那
        AppConfig::query()
            ->whereIn('key', [
                'meedu.member.socialite.github.enabled',
                'services.github.client_id',
                'services.github.client_secret',
                'services.github.redirect',

                'meedu.member.socialite.weixinweb.enabled',
                'services.weixinweb.client_id',
                'services.weixinweb.client_secret',
                'services.weixinweb.redirect',
            ])
            ->delete();

        // 删除QQ互联登录的回调地址配置
        // meedu v4.0版本开始无需手动配置
        AppConfig::query()
            ->where('key', 'services.qq.redirect')
            ->delete();

        // 删除支付宝和微信支付的url配置
        // meedu v4.0将会自动解析
        AppConfig::query()
            ->whereIn('key', [
                'pay.alipay.return_url',
                'pay.alipay.notify_url',

                'pay.wechat.notify_url',
            ])
            ->delete();
    }

    public static function removeAdminMenu()
    {
        // 删除后台视频列表menu
        AdministratorMenu::query()
            ->where('url', 'Video')
            ->delete();

        // 更新后台视频Menu的文案
        AdministratorMenu::query()
            ->where('url', 'videomanage')
            ->update(['name' => '点播']);
    }
}
