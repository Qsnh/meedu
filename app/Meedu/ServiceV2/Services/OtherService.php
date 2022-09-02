<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use App\Meedu\ServiceV2\Dao\OtherDaoInterface;

class OtherService implements OtherServiceInterface
{
    protected $otherDao;

    public function __construct(OtherDaoInterface $otherDao)
    {
        $this->otherDao = $otherDao;
    }

    public function storeUserUploadImage(int $userId, string $group, string $disk, string $path, string $name, string $visitUrl, string $logApi, string $logIp, string $logUA): void
    {
        if (mb_strlen($logUA) > 255) {
            $logUA = mb_substr($logUA, 0, 255);
        }

        $this->otherDao->storeUserUploadImage($userId, $group, $disk, $path, $name, $visitUrl, $logApi, $logIp, $logUA);
    }
}
