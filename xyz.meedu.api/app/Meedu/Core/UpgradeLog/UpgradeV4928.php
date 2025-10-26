<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Models\AdministratorPermission;

class UpgradeV4928
{

    public static function handle()
    {
        self::removeSomePermissions();
    }

    private static function removeSomePermissions()
    {
        AdministratorPermission::query()
            ->whereIn('slug', [
                'viewBlock',
                'viewBlock.store',
                'viewBlock.update',
                'viewBlock.destroy',

                'slider',
                'slider.store',
                'slider.update',
                'slider.destroy',
            ])
            ->delete();
    }

}
