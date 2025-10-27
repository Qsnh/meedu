<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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

    public function test_addons_provider_map_command()
    {
        $this->artisan('addons:provider:map')
            ->assertExitCode(0);
    }
}
