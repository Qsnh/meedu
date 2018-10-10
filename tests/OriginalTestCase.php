<?php
/**
 * Created by PhpStorm.
 * User: xiaoteng
 * Date: 2018/10/9
 * Time: 15:24
 */

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class OriginalTestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;
}