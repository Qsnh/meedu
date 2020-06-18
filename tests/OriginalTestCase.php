<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class OriginalTestCase extends \Illuminate\Foundation\Testing\TestCase
{
    use CreatesApplication, RefreshDatabase;
}
