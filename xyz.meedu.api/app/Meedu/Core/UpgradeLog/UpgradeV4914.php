<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeV4914
{

    public static function handle()
    {
        self::deleteAppConfigs();
        self::configRename();
    }

    private static function configRename()
    {
        AppConfig::query()
            ->where('key', 'meedu.payment.wechat.enabled')
            ->update([
                'name' => '微信支付',
            ]);
    }

    private static function deleteAppConfigs()
    {
        AppConfig::query()
            ->whereIn('key', [
                'meedu.payment.wechat-jsapi.enabled',
            ])
            ->delete();
    }

}
