<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Models\AdministratorPermission;

class UpgradeV4929
{
    public static function handle()
    {
        self::removeSomePermissions();
    }

    private static function removeSomePermissions()
    {
        AdministratorPermission::query()
            ->whereIn('slug', [
                'video.subscribes',
                'video.subscribe.create',
                'video.subscribe.delete',

                'v2.member.videos',
                'video.subscribes',
                'video.subscribe.create',
                'video.subscribe.delete',

                'member.detail.userCourses',
                'member.detail.userVideos',
                'member.detail.userRoles',
                'member.detail.userCollect',
                'member.detail.userHistory',
                'member.video.watch.records',
            ])
            ->delete();
    }

}
