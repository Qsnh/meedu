<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

interface AgreementServiceInterface
{
    public function checkUserRequiredAgreements(int $userId): bool;

    public function getActiveAgreement(string $type): array;

    public function getActiveAgreementId(string $type): int;

    public function recordUserAgreement(int $userId, int $agreementId, string $ip, string $userAgent, string $platform): array;

    public function getUserAgreementStatus(int $userId): array;

    public function getRequiredAgreements(): array;
}
