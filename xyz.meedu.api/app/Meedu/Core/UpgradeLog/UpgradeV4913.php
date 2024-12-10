<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Models\AdministratorPermission;
use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeV4913
{

    public static function handle()
    {
        self::deleteConfigs();
        self::updateCourseAttachPermission();
    }

    private static function deleteConfigs()
    {
        AppConfig::query()
            ->whereIn('key', [
                'meedu.upload.image.disk',
                'filesystems.disks.oss.access_id',
                'filesystems.disks.oss.access_key',
                'filesystems.disks.oss.bucket',
                'filesystems.disks.oss.endpoint',
                'filesystems.disks.oss.cdnDomain',

                'filesystems.disks.cos.region',
                'filesystems.disks.cos.credentials.appId',
                'filesystems.disks.cos.credentials.secretId',
                'filesystems.disks.cos.credentials.secretKey',
                'filesystems.disks.cos.bucket',
                'filesystems.disks.cos.cdn',
            ])
            ->delete();
    }

    private static function updateCourseAttachPermission()
    {
        AdministratorPermission::query()
            ->where('slug', 'course_attach.store')
            ->update(['url' => '(^course_attach|^course_attach\/create$)']);
    }

}
