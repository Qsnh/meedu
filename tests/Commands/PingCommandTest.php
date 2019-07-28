<?php


namespace Tests\Commands;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class PingCommandTest extends TestCase
{

    use CreatesApplication;

    public function test_ping()
    {
        $this->artisan('ping')
            ->assertExitCode(0);
    }

}