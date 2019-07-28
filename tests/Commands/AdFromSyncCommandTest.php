<?php


namespace Tests\Commands;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class AdFromSyncCommandTest extends TestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function test_ad_from_sync_command()
    {
        $this->artisan('adfrom:sync')
            ->assertExitCode(0);
    }

}