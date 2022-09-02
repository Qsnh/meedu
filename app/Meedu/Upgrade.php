<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu;

use App\Meedu\UpgradeLog\UpgradeTo48;
use App\Meedu\UpgradeLog\UpgradeToV4;
use App\Meedu\UpgradeLog\UpgradeToV42;
use App\Meedu\UpgradeLog\UpgradeToV45;
use App\Meedu\UpgradeLog\UpgradeToV46;
use App\Meedu\UpgradeLog\UpgradeToV454;

class Upgrade
{
    public function run()
    {
        UpgradeToV4::handle();
        UpgradeToV42::handle();
        UpgradeToV45::handle();
        UpgradeToV454::handle();
        UpgradeToV46::handle();
        UpgradeTo48::handle();
    }
}
