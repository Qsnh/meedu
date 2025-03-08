<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Models\AdministratorPermission;

class UpgradeV4920
{

    public static function handle()
    {
        self::removePermission();
    }

    private static function removePermission()
    {
        AdministratorPermission::query()
            ->whereIn('slug', [
                'media.video-category.index',
                'system.log.userLogin',
                'system.log.uploadImages',
                'system.log.runtime',
                'system.log.admin',
                'system.log.delete',

                'statistic.userRegister',
                'statistic.orderCreated',
                'statistic.orderPaidCount',
                'statistic.orderPaidSum',
                'statistic.courseSell',
                'statistic.roleSell',
                'statistic.videoWatchDuration',
                'statistic.courseWatchDuration',
            ])
            ->delete();
    }

}
