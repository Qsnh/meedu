<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeV498
{

    public static function handle()
    {
        self::removeAppConfig();
    }

    private static function removeAppConfig()
    {
        AppConfig::query()
            ->whereIn('key', [
                'meedu.member.protocol',
                'meedu.member.private_protocol',
            ])
            ->update(['field_type' => 'textarea']);
    }

}
