<?php


namespace Tests;


use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class OriginalTestCase extends \Illuminate\Foundation\Testing\TestCase
{

    use CreatesApplication, RefreshDatabase;

}