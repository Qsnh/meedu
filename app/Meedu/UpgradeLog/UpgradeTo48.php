<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\UpgradeLog;

use App\Services\Base\Model\AppConfig;

class UpgradeTo48
{
    public static function handle()
    {
        self::deleteConfig();
    }

    public static function deleteConfig()
    {
        AppConfig::query()
            ->whereIn('key', [
                'meedu.member.invite.free_user_enabled',
                'meedu.member.invite.invite_user_reward',
                'meedu.member.invite.invited_user_reward',
                'meedu.member.invite.effective_days',
                'meedu.member.invite.per_order_draw',
            ])
            ->delete();
    }
}
