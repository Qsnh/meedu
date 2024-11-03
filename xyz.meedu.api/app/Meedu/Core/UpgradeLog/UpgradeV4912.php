<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeV4912
{

    public static function handle()
    {
        self::deleteSomeConfigItems();
        self::renameWechatLoginKeyName();
    }

    private static function deleteSomeConfigItems()
    {
        AppConfig::query()
            ->whereIn('key', [
                'meedu.mp_wechat.enabled_scan_login',
                'meedu.mp_wechat.scan_login_alert',
            ])
            ->delete();
    }

    private static function renameWechatLoginKeyName()
    {
        AppConfig::query()
            ->where('key', 'meedu.mp_wechat.enabled_oauth_login')
            ->update(['name' => '启动微信登录']);
    }

}
