<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

interface OtherServiceInterface
{
    public function storeUserUploadImage(
        int $userId,
        string $group,
        string $disk,
        string $path,
        string $name,
        string $visitUrl,
        string $logApi,
        string $logIp,
        string $logUA
    ): void;
}
