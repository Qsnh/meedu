<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Commands;

use Tests\OriginalTestCase;

class MemberRoleExpiredHandlerCommandTest extends OriginalTestCase
{
    public function test_run()
    {
        $this->artisan('member:role:expired')->assertExitCode(0);
    }
}
