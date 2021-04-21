<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace Tests\Commands;

use Tests\OriginalTestCase;

class AddonsProviderMapGeneratorTest extends OriginalTestCase
{
    public function tearDown():void
    {
        @unlink(base_path('addons/addons_service_provider.json'));
        parent::tearDown();
    }

    public function test_ad_from_sync_command()
    {
        $this->artisan('addons:provider:map')
            ->assertExitCode(0);
    }
}
