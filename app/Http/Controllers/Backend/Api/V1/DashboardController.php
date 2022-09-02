<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use App\Meedu\MeEdu;
use App\Models\AdministratorLog;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;

class DashboardController extends BaseController
{
    public function index()
    {
        // 今日注册用户数
        $todayRegisterUserCount = User::query()->where('created_at', '>=', date('Y-m-d'))->count();
        // 总用户数
        $userCount = User::query()->count();

        // 昨日订单支付总额
        $yesterdayPaidSum = (int)Order::query()
            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d'), date('Y-m-d')])
            ->where('status', Order::STATUS_PAID)
            ->sum('charge');

        // 今日订单支付总额
        $todayPaidSum = (int)Order::query()
            ->where('created_at', '>=', date('Y-m-d'))
            ->where('status', Order::STATUS_PAID)
            ->sum('charge');

        // 进入付费用户数量
        $todayPaidUserNum = Order::query()
            ->select(['user_id'])
            ->where('created_at', '>=', date('Y-m-d'))
            ->where('status', Order::STATUS_PAID)
            ->groupBy('user_id')
            ->count();

        // 昨日付费用户数量
        $yesterdayPaidUserNum = Order::query()
            ->select(['user_id'])
            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d'), date('Y-m-d')])
            ->where('status', Order::STATUS_PAID)
            ->groupBy('user_id')
            ->count();

        // 本月收益
        $thisMonthPaidSum = (int)Order::query()
            ->where('created_at', '>=', date('Y-m') . '-01')
            ->where('status', Order::STATUS_PAID)
            ->sum('charge');
        // 上个月收益
        $lastMonthPaidSum = (int)Order::query()
            ->whereBetween('created_at', [Carbon::now()->subMonths(1)->format('Y-m') . '-01', date('Y-m') . '-01'])
            ->where('status', Order::STATUS_PAID)
            ->sum('charge');

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_DASHBOARD,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData([
            'today_register_user_count' => $todayRegisterUserCount,
            'user_count' => $userCount,

            // 支付额度
            'today_paid_sum' => $todayPaidSum,
            'yesterday_paid_sum' => $yesterdayPaidSum,

            // 支付用户数
            'today_paid_user_num' => $todayPaidUserNum,
            'yesterday_paid_user_num' => $yesterdayPaidUserNum,

            // 月度收益
            'this_month_paid_sum' => $thisMonthPaidSum,
            'last_month_paid_sum' => $lastMonthPaidSum,
        ]);
    }

    public function check()
    {
        if (!file_exists(storage_path('install.lock'))) {
            return $this->error(__('请运行php artisan install:lock命令生成安装锁文件'));
        }
        if (file_exists(base_path('public/install.php'))) {
            return $this->error(__('请删除傻瓜安装脚本public/install.php文件'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_DASHBOARD,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->success();
    }

    public function systemInfo()
    {
        $info = [
            'meedu_version' => MeEdu::VERSION,
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
        ];

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_DASHBOARD,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData($info);
    }
}
