<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core;

use App\Meedu\Core\UpgradeLog\UpgradeTo48;
use App\Meedu\Core\UpgradeLog\UpgradeToV4;
use App\Meedu\Core\UpgradeLog\UpgradeV493;
use App\Meedu\Core\UpgradeLog\UpgradeV498;
use App\Meedu\Core\UpgradeLog\UpgradeToV42;
use App\Meedu\Core\UpgradeLog\UpgradeToV45;
use App\Meedu\Core\UpgradeLog\UpgradeToV46;
use App\Meedu\Core\UpgradeLog\UpgradeV4910;
use App\Meedu\Core\UpgradeLog\UpgradeV4912;
use App\Meedu\Core\UpgradeLog\UpgradeV4913;
use App\Meedu\Core\UpgradeLog\UpgradeV4914;
use App\Meedu\Core\UpgradeLog\UpgradeToV454;
use App\Meedu\Core\UpgradeLog\UpgradeToV4911;

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
        UpgradeV493::handle();
        UpgradeV498::handle();
        UpgradeV4910::handle();
        UpgradeToV4911::handle();
        UpgradeV4912::handle();
        UpgradeV4913::handle();
        UpgradeV4914::handle();
    }
}
