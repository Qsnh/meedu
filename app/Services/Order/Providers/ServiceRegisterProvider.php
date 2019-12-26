<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Order\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceRegisterProvider extends ServiceProvider
{
    public function __construct($app)
    {
        parent::__construct($app);
    }

    public function register()
    {
    }
}
