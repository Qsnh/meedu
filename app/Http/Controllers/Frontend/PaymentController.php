<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Meedu\Payment\Youzan\Youzan;

class PaymentController extends FrontendController
{
    public function callback()
    {
        return (new Youzan())->callback();
    }
}
