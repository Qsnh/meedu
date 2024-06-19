<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V2;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Constant\TableConstant;
use App\Models\AdministratorLog;
use Illuminate\Support\Facades\DB;
use App\Meedu\ServiceV2\Models\User;
use App\Services\Order\Models\Order;
use App\Services\Order\Models\OrderRefund;
use App\Services\Member\Models\UserWatchStat;

class StatsController extends BaseController
{
    // 每日交易数据统计
    public function transaction()
    {
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATUS_V2,
            AdministratorLog::OPT_VIEW,
            []
        );

        //今日支付总额
        $todayPaidSum = (int)Order::query()
            ->where('created_at', '>=', date('Y-m-d'))
            ->where('status', Order::STATUS_PAID)
            ->sum('charge');

        //昨日支付总额
        $yesterdayPaidSum = (int)Order::query()
            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d'), date('Y-m-d')])
            ->where('status', Order::STATUS_PAID)
            ->sum('charge');

        //今日退款总额
        $todayRefundSum = (int)OrderRefund::query()
                ->where('created_at', '>=', date('Y-m-d'))
                ->sum('amount') / 100;

        //今日已支付订单数
        $todayPaidCount = Order::query()
            ->where('created_at', '>=', date('Y-m-d'))
            ->where('status', Order::STATUS_PAID)
            ->count();

        //昨日已支付订单数
        $yesterdayPaidCount = Order::query()
            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d'), date('Y-m-d')])
            ->where('status', Order::STATUS_PAID)
            ->count();

        //今日退款订单数
        $todayRefundCount = OrderRefund::query()->distinct('order_id')->where('created_at', '>=', date('Y-m-d'))->count();

        //今日已支付订单人数
        $todayPaidUserCount = Order::query()
            ->where('created_at', '>=', date('Y-m-d'))
            ->where('status', Order::STATUS_PAID)
            ->distinct('user_id')
            ->count();

        //昨日已支付订单人数
        $yesterdayPaidUserCount = Order::query()
            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d'), date('Y-m-d')])
            ->where('status', Order::STATUS_PAID)
            ->distinct('user_id')
            ->count();

        //今日订单创建数量
        $todayCount = Order::query()
            ->where('created_at', '>=', date('Y-m-d'))
            ->count();

        //昨日订单创建数量
        $yesterdayCount = Order::query()
            ->whereBetween('created_at', [Carbon::now()->subDays(1)->format('Y-m-d'), date('Y-m-d')])
            ->count();

        return $this->successData([
            'today_paid_sum' => $todayPaidSum,//今日已支付金额
            'yesterday_paid_sum' => $yesterdayPaidSum,//昨日已支付金额
            'today_refund_sum' => $todayRefundSum,//今日退款金额
            'today_paid_count' => $todayPaidCount,//今日已支付订单数量
            'yesterday_paid_count' => $yesterdayPaidCount,//昨日已支付订单数量
            'today_refund_count' => $todayRefundCount,//今日退款订单数量
            'today_paid_user_count' => $todayPaidUserCount,//今日已支付用户数量
            'yesterday_paid_user_count' => $yesterdayPaidUserCount,//昨日已支付用户数量
            'today_count' => $todayCount,//今日订单创建数量
            'yesterday_count' => $yesterdayCount,//昨日订单创建数量

            // 今日客单价 = 今日支付总额 / 今日支付学员数
            // 昨日客单价 = 昨日支付总额 / 昨日支付学员数
        ]);
    }

    //交易排名
    public function transactionTop(Request $request)
    {
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATUS_V2,
            AdministratorLog::OPT_VIEW,
            []
        );

        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 10);
        $offset = ($page - 1) * $size;

        $goodsType = $request->input('goods_type');

        $statAt = $request->input('start_at');
        $endAt = $request->input('end_at');
        if (!$statAt || !$endAt || Carbon::parse($statAt)->gte($endAt)) {
            return $this->error(__('参数错误'));
        }

        $statAt = Carbon::parse($statAt)->toDateTimeLocalString();
        $endAt = Carbon::parse($endAt)->toDateTimeLocalString();

        $tableOrders = TableConstant::TABLE_ORDERS;
        $tableOrderGoods = TableConstant::TABLE_ORDER_GOODS;

        $queryParams = [$statAt, $endAt];

        $goodsTypeSql = '';
        if ($goodsType) {
            $goodsTypeSql = ' and ' . $tableOrderGoods . '.goods_type=? ';
            $queryParams[] = $goodsType;
        }

        $countSql = <<<SQL
SELECT count(*) as `document_count` from (
    SELECT
        {$tableOrderGoods}.`goods_id`
FROM {$tableOrders}
INNER JOIN {$tableOrderGoods}
    ON {$tableOrderGoods}.`oid` = {$tableOrders}.`id`
WHERE {$tableOrders}.`status` = 9 and {$tableOrders}.`created_at` between ? and ? {$goodsTypeSql}
GROUP BY  {$tableOrderGoods}.`goods_id`,{$tableOrderGoods}.`goods_name`
) as `tmp_order_goods_table`;
SQL;

        $sql = <<<SQL
SELECT
        {$tableOrderGoods}.`goods_id`,
        {$tableOrderGoods}.`goods_name`,
        count({$tableOrders}.`id`) AS `orders_count`,
        sum({$tableOrders}.`charge`) AS `orders_paid_sum`
FROM {$tableOrders}
INNER JOIN {$tableOrderGoods}
    ON {$tableOrderGoods}.`oid` = {$tableOrders}.`id`
WHERE {$tableOrders}.`status` = 9 and {$tableOrders}.`created_at` between ? and ? {$goodsTypeSql}
GROUP BY  {$tableOrderGoods}.`goods_id`,{$tableOrderGoods}.`goods_name`
ORDER BY  `orders_paid_sum` desc
limit {$offset},{$size};
SQL;

        $count = DB::selectOne($countSql, $queryParams);
        $result = DB::select($sql, $queryParams);

        return $this->successData([
            'data' => $result,
            'total' => $count->document_count,
        ]);
    }

    public function transactionGraph(Request $request)
    {
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATUS_V2,
            AdministratorLog::OPT_VIEW,
            []
        );

        $statAt = $request->input('start_at');//格式:Y-m-d
        $endAt = $request->input('end_at');//同上
        if (!$statAt || !$endAt || Carbon::parse($statAt)->gte($endAt)) {
            return $this->error(__('参数错误'));
        }

        $statAt = Carbon::parse($statAt)->toDateTimeLocalString();
        $endAt = Carbon::parse($endAt)->toDateTimeLocalString();

        $paidSum = []; //每日支付金额
        $paidCount = []; //每日已支付订单数
        $paidUserCount = []; //每日已支付学员数
        $paidAvgCharge = []; //客单价

        $tmpDate = Carbon::parse($statAt);
        while ($tmpDate->lt($endAt)) {
            $tmpAt = $tmpDate->format('Y-m-d');
            $paidSum[$tmpAt] = 0;
            $paidCount[$tmpAt] = 0;
            $paidUserCount[$tmpAt] = [];
            $paidAvgCharge[$tmpAt] = 0;

            $tmpDate->addDays(1);
        }

        //读取这段时间的已支付订单
        $orders = Order::query()
            ->whereBetween('created_at', [$statAt, $endAt])
            ->where('status', Order::STATUS_PAID)
            ->get();

        foreach ($orders as $tmpOrderItem) {
            $tmpDate = Carbon::parse($tmpOrderItem['created_at'])->format('Y-m-d');

            $paidSum[$tmpDate] += $tmpOrderItem['charge'];//每日支付金额
            $paidCount[$tmpDate] += 1;//每日订单数量
            $paidUserCount[$tmpDate][] = $tmpOrderItem['user_id'];
        }

        foreach ($paidSum as $key => $daySum) {//每日客单价计算
            $tmpCount = count($paidUserCount[$key] ?? []);
            $paidAvgCharge[$key] = $tmpCount === 0 ? 0 : (int)($daySum / $tmpCount);
        }

        foreach ($paidUserCount as $key => $tmpItem) {
            $paidUserCount[$key] = count(array_unique($tmpItem));
        }

        return $this->successData([
            'paid_sum' => $paidSum,//每日支付额度
            'paid_count' => $paidCount,//每日支付订单数量
            'paid_user_count' => $paidUserCount,//每日支付用户数量
            'paid_avg_charge' => $paidAvgCharge,//每日客单价
        ]);
    }

    public function userPaidTop(Request $request)
    {
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATUS_V2,
            AdministratorLog::OPT_VIEW,
            []
        );

        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 10);
        $offset = ($page - 1) * $size;

        $statAt = $request->input('start_at');//格式:Y-m-d
        $endAt = $request->input('end_at');//同上
        if (!$statAt || !$endAt || Carbon::parse($statAt)->gte($endAt)) {
            return $this->error(__('参数错误'));
        }

        $statAt = Carbon::parse($statAt)->toDateTimeLocalString();
        $endAt = Carbon::parse($endAt)->toDateTimeLocalString();

        $tableOrders = TableConstant::TABLE_ORDERS;

        $countSql = <<<SQL
select count(distinct `user_id`) as document_count from `{$tableOrders}` where `status` = ? and `created_at` between ? and ?;
SQL;

        $sql = <<<SQL
select `user_id`,sum(`charge`) as `total`,count(`id`) as `count` from `{$tableOrders}` where `status` = ? and `created_at` between ? and ? group by `user_id` order by `total` desc limit ?,?;
SQL;

        $countResult = DB::selectOne($countSql, [Order::STATUS_PAID, $statAt, $endAt]);
        $data = DB::select($sql, [Order::STATUS_PAID, $statAt, $endAt, $offset, $size]);
        if ($data) {
            $data = json_decode(json_encode($data), true);
            $userIds = array_column($data, 'user_id');
            $users = User::query()->select(['id', 'nick_name', 'avatar'])->whereIn('id', $userIds)->get()->keyBy('id')->toArray();
            foreach ($data as $key => $tmpItem) {
                $data[$key]['user'] = $users[$tmpItem['user_id']] ?? [];
            }
        }

        return $this->successData([
            'total' => $countResult ? $countResult->document_count : 0,
            'data' => $data,
        ]);
    }

    public function user()
    {
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATUS_V2,
            AdministratorLog::OPT_VIEW,
            []
        );

        $today = explode('-', Carbon::now()->format('Y-m-d'));
        $yesterday = explode('-', Carbon::now()->subDays(1)->format('Y-m-d'));

        //今日观看视频人数
        $todayWatchCount = UserWatchStat::query()
            ->where('year', $today[0])
            ->where('month', $today[1])
            ->where('day', $today[2])
            ->count();

        //昨日观看视频人数
        $yesterdayWatchCount = UserWatchStat::query()
            ->where('year', $yesterday[0])
            ->where('month', $yesterday[1])
            ->where('day', $yesterday[2])
            ->count();

        $todayDate = Carbon::now()->format('Y-m-d');

        //用户总数
        $userCount = User::query()->count();
        //今日注册数量
        $todayCount = User::query()->where('created_at', '>=', $todayDate)->count();
        //昨日注册数量
        $yesterdayCount = User::query()
            ->whereBetween('created_at', [Carbon::now()->subDays()->format('Y-m-d'), $todayDate])
            ->count();
        //本周注册人数
        $weekCount = User::query()
            ->whereBetween('created_at', [Carbon::now()->startOfWeek()->format('Y-m-d'), $todayDate])
            ->count();
        //本月注册人数
        $monthCount = User::query()
            ->whereBetween('created_at', [Carbon::now()->startOfMonth()->format('Y-m-d'), $todayDate])
            ->count();

        return $this->successData([
            'user_count' => $userCount,//总人数
            'yesterday_count' => $yesterdayCount,//昨日注册人数
            'today_count' => $todayCount,//今日注册人数
            'week_count' => $weekCount,//本周注册人数
            'month_count' => $monthCount,//本月注册人数

            'today_watch_count' => $todayWatchCount,//今日观看视频人数
            'yesterday_watch_count' => $yesterdayWatchCount,//昨日观看视频人数
        ]);
    }

    public function userGraph(Request $request)
    {
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATUS_V2,
            AdministratorLog::OPT_VIEW,
            []
        );

        $statAt = $request->input('start_at');//格式:Y-m-d
        $endAt = $request->input('end_at');//同上
        if (!$statAt || !$endAt || Carbon::parse($statAt)->gte($endAt)) {
            return $this->error(__('参数错误'));
        }

        $statAt = Carbon::parse($statAt)->toDateTimeLocalString();
        $endAt = Carbon::parse($endAt)->toDateTimeLocalString();

        $tableOrders = TableConstant::TABLE_ORDERS;

        //读取时间范围内创建订单并支付的用户ids
        $userIds = Order::query()
            ->select(['user_id'])
            ->distinct('user_id')
            ->where('status', Order::STATUS_PAID)
            ->whereBetween('created_at', [$statAt, $endAt])
            ->get();
        $userIds = $userIds->pluck('user_id')->toArray();

        //读取用户的已支付订单数量
        $sql = <<<SQL
select `user_id`,count(`id`) as `paid_count` from `{$tableOrders}` where `status` = ? group by `user_id`;
SQL;
        $paidCount = DB::select($sql, [Order::STATUS_PAID]);
        $paidCount = json_decode(json_encode($paidCount), true);
        $paidCount = array_column($paidCount, null, 'user_id');

        $firstCount = 0;
        $nonFirstCount = 0;

        foreach ($userIds as $tmpUserId) {
            $tmpPaidCount = isset($paidCount[$tmpUserId]) ? $paidCount[$tmpUserId]['paid_count'] : 0;
            if ($tmpPaidCount <= 1) {
                $firstCount++;
            } else {
                $nonFirstCount++;
            }
        }

        return $this->successData([
            'first-non-first' => [//首次付费-非首次付费
                'first_count' => $firstCount,//首次付费人数
                'non_first_count' => $nonFirstCount,//非首次付费人数
            ],
        ]);
    }
}
