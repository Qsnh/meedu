<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class OriginalTestCase extends \Illuminate\Foundation\Testing\TestCase
{
    use CreatesApplication, RefreshDatabase;
}
