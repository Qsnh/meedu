<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\User;
use App\Meedu\MeEdu;
use App\Models\Order;

class DashboardController extends BaseController
{
    public function index()
    {
        $todayRegisterUserCount = User::todayRegisterCount();
        $todayPaidNum = Order::todayPaidNum();
        $todayPaidSum = Order::todayPaidSum();

        return $this->successData([
            'today_register_user_count' => $todayRegisterUserCount,
            'today_paid_num' => $todayPaidNum,
            'today_paid_sum' => $todayPaidSum,
        ]);
    }

    public function systemInfo()
    {
        $info = [
            'meedu_version' => MeEdu::VERSION,
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
        ];
        return $this->successData($info);
    }
}
