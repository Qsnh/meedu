<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Impl;

use Illuminate\Support\Facades\Cache;
use App\Meedu\ServiceV2\Services\AgreementServiceInterface;

class ActiveAgreementCache
{

    public const CACHE_KEY = 'active_agreement_%s';
    public const CACHE_EXPIRE = 1296000;//15天

    public static function getActiveId(string $type): int
    {
        $agreement = self::getActiveAgreement($type);
        return $agreement ? $agreement['id'] : 0;
    }

    public static function getActiveAgreement(string $type): array
    {
        return Cache::remember(self::keyName($type), self::CACHE_EXPIRE, function () use ($type) {
            /**
             * @var AgreementServiceInterface $agreementService
             */
            $agreementService = app()->make(AgreementServiceInterface::class);
            return $agreementService->getActiveAgreement($type);
        });
    }

    public static function forget(string $type): void
    {
        Cache::forget(self::keyName($type));
    }

    private static function keyName(string $type): string
    {
        return sprintf(self::CACHE_KEY, $type);
    }

}
