<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;
}
