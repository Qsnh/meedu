<?php


namespace Tests\Commands;

use Tests\OriginalTestCase;

class MemberRoleExpiredHandlerCommandTest extends OriginalTestCase
{

    public function test_run()
    {
        $this->artisan('member:role:expired')->assertExitCode(0);
    }

}