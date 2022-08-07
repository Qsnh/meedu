<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

interface ConfigServiceInterface
{
    public function getSuperAdministratorSlug(): string;

    public function getEnabledSocialiteApps(): array;
}
