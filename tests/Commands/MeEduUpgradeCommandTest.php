<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Commands;

use Tests\OriginalTestCase;

class MeEduUpgradeCommandTest extends OriginalTestCase
{
    public function test_upgrade()
    {
        $this->artisan('meedu:upgrade')->assertSuccessful();
    }
}
