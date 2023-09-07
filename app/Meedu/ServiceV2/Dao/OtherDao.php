<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

use Carbon\Carbon;
use App\Meedu\ServiceV2\Models\AppConfig;
use App\Meedu\ServiceV2\Models\UserUploadImage;

class OtherDao implements OtherDaoInterface
{
    public function storeUserUploadImage(int $userId, string $group, string $disk, string $path, string $name, string $visitUrl, string $logApi, string $logIp, string $logUA): void
    {
        UserUploadImage::create([
            'user_id' => $userId,
            'group' => $group,
            'disk' => $disk,
            'path' => $path,
            'name' => $name,
            'visit_url' => $visitUrl,
            'log_api' => $logApi,
            'log_ip' => $logIp,
            'log_ua' => $logUA,
            'created_at' => Carbon::now()->toDateTimeLocalString(),
        ]);
    }

    public function appConfigValueKey(): array
    {
        return AppConfig::query()->get()->pluck('value', 'key')->toArray();
    }


}
