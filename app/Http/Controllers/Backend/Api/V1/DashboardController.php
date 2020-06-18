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

use App\Meedu\MeEdu;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;

class DashboardController extends BaseController
{
    public function index()
    {
        $todayRegisterUserCount = User::query()->where('created_at', '>=', date('Y-m-d'))->count();
        $todayPaidNum = Order::todayPaidNum();
        $todayPaidSum = Order::todayPaidSum();

        return $this->successData([
            'today_register_user_count' => $todayRegisterUserCount,
            'today_paid_num' => $todayPaidNum,
            'today_paid_sum' => $todayPaidSum,
        ]);
    }

    public function check()
    {
        if (!file_exists(storage_path('install.lock'))) {
            return $this->error('请运行php artisan install:lock命令生成安装锁文件。');
        }
        if (file_exists(base_path('public/install.php'))) {
            return $this->error('请删除傻瓜安装脚本public/install.php文件。');
        }
        return $this->success();
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
