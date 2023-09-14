<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use App\Meedu\MeEdu;
use Illuminate\Http\Request;
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
            ->distinct('user_id')
            ->where('created_at', '>=', date('Y-m-d'))
            ->where('status', Order::STATUS_PAID)
            ->count();

        // 昨日付费用户数量
        $yesterdayPaidUserNum = Order::query()
            ->distinct('user_id')
            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d'), date('Y-m-d')])
            ->where('status', Order::STATUS_PAID)
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

    public function graph(Request $request)
    {
        $startAt = $request->input('start_at');
        $endAt = $request->input('end_at');
        if (!$startAt || !$endAt) {
            return $this->error(__('参数错误'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_DASHBOARD,
            AdministratorLog::OPT_VIEW,
            []
        );

        $startAt = Carbon::parse($startAt)->format('Y-m-d');

        $endAt = Carbon::parse($endAt)->format('Y-m-d') . ' 23:59:59';
        $endAtCarbon = Carbon::parse($endAt);

        // 每日注册学员数量统计
        $userRegister = [];
        // 每日订单创建数量统计
        $orderCreated = [];
        // 每日已支付订单数量统计
        $orderPaid = [];
        // 每日支付总额统计
        $orderSum = [];

        $tmpAt = Carbon::parse($startAt);

        while ($endAtCarbon->gt($tmpAt)) {
            $tmpKey = $tmpAt->format('Y-m-d');

            $userRegister[$tmpKey] = 0;
            $orderCreated[$tmpKey] = 0;
            $orderPaid[$tmpKey] = 0;
            $orderSum[$tmpKey] = 0;

            $tmpAt->addDays();
        }

        $users = User::query()
            ->select(['created_at'])
            ->whereBetween('created_at', [$startAt, $endAt])
            ->get();
        foreach ($users as $tmpVal) {
            $tmpDate = Carbon::parse($tmpVal['created_at'])->format('Y-m-d');
            $userRegister[$tmpDate]++;
        }

        $createdOrders = Order::query()
            ->select(['created_at'])
            ->whereBetween('created_at', [$startAt, $endAt])
            ->get();
        foreach ($createdOrders as $tmpVal) {
            $tmpDate = Carbon::parse($tmpVal['created_at'])->format('Y-m-d');
            $orderCreated[$tmpDate]++;
        }

        $paidOrders = Order::query()
            ->select(['created_at', 'charge'])
            ->where('status', Order::STATUS_PAID)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->get();
        foreach ($paidOrders as $tmpVal) {
            $tmpDate = Carbon::parse($tmpVal['created_at'])->format('Y-m-d');
            $orderPaid[$tmpDate]++;
            $orderSum[$tmpDate] += $tmpVal['charge'];
        }

        return $this->successData([
            'user_register' => $userRegister,
            'order_created' => $orderCreated,
            'order_paid' => $orderPaid,
            'order_sum' => $orderSum,
        ]);
    }
}
