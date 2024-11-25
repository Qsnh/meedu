<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Models\AdministratorPermission;
use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeV4912
{

    public static function handle()
    {
        self::deleteSomeConfigItems();
        self::renameWechatLoginKeyName();
        self::deleteSomePermissions();
        self::updateSmsServiceValue();
    }

    private static function deleteSomePermissions()
    {
        AdministratorPermission::query()
            ->whereIn('slug', [
                'mpWechatMessageReply',
                'mpWechatMessageReply.store',
                'mpWechatMessageReply.update',
                'mpWechatMessageReply.destroy',
                'mpWechat.menu',
                'mpWechat.menu.update',
                'mpWechat.menu.empty',
            ])
            ->delete();
    }

    private static function deleteSomeConfigItems()
    {
        AppConfig::query()
            ->whereIn('key', [
                'meedu.mp_wechat.enabled_scan_login',
                'meedu.mp_wechat.scan_login_alert',

                'sms.gateways.yunpian.api_key',
                'sms.gateways.yunpian.template.password_reset',
                'sms.gateways.yunpian.template.register',
                'sms.gateways.yunpian.template.mobile_bind',
                'sms.gateways.yunpian.template.login',
            ])
            ->delete();
    }

    private static function renameWechatLoginKeyName()
    {
        AppConfig::query()
            ->where('key', 'meedu.mp_wechat.enabled_oauth_login')
            ->update(['name' => '启动微信登录']);
    }

    private static function updateSmsServiceValue()
    {
        AppConfig::query()
            ->where('key', 'meedu.system.sms')
            ->update(
                [
                    'option_value' => json_encode(
                        [
                            [
                                'title' => '阿里云',
                                'key' => 'aliyun',
                            ],
                            [
                                'title' => '腾讯云',
                                'key' => 'tencent',
                            ],
                        ]
                    ),
                ]
            );
    }

}
