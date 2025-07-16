<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core;

use App\Meedu\Core\UpgradeLog\UpgradeV400;
use App\Meedu\Core\UpgradeLog\UpgradeV420;
use App\Meedu\Core\UpgradeLog\UpgradeV450;
use App\Meedu\Core\UpgradeLog\UpgradeV454;
use App\Meedu\Core\UpgradeLog\UpgradeV460;
use App\Meedu\Core\UpgradeLog\UpgradeV480;
use App\Meedu\Core\UpgradeLog\UpgradeV493;
use App\Meedu\Core\UpgradeLog\UpgradeV498;
use App\Meedu\Core\UpgradeLog\UpgradeV4910;
use App\Meedu\Core\UpgradeLog\UpgradeV4911;
use App\Meedu\Core\UpgradeLog\UpgradeV4912;
use App\Meedu\Core\UpgradeLog\UpgradeV4913;
use App\Meedu\Core\UpgradeLog\UpgradeV4914;
use App\Meedu\Core\UpgradeLog\UpgradeV4915;
use App\Meedu\Core\UpgradeLog\UpgradeV4917;
use App\Meedu\Core\UpgradeLog\UpgradeV4920;
use App\Meedu\Core\UpgradeLog\UpgradeV4922;
use App\Meedu\Core\UpgradeLog\UpgradeV4927;

class Upgrade
{
    public function run()
    {
        UpgradeV400::handle();
        UpgradeV420::handle();
        UpgradeV450::handle();
        UpgradeV454::handle();
        UpgradeV460::handle();
        UpgradeV480::handle();
        UpgradeV493::handle();
        UpgradeV498::handle();
        UpgradeV4910::handle();
        UpgradeV4911::handle();
        UpgradeV4912::handle();
        UpgradeV4913::handle();
        UpgradeV4914::handle();
        UpgradeV4915::handle();
        UpgradeV4917::handle();
        UpgradeV4922::handle();
        UpgradeV4920::handle();
        UpgradeV4922::handle();
        UpgradeV4927::handle();
    }
}
