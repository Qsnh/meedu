<?php


namespace Tests\Commands;

use Tests\OriginalTestCase;

class AdFromSyncCommandTest extends OriginalTestCase
{

    public function test_ad_from_sync_command()
    {
        $this->artisan('adfrom:sync')
            ->assertExitCode(0);
    }

}