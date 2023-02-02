<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V2;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Constant\TableConstant;
use Illuminate\Support\Facades\DB;
use App\Services\Order\Models\Order;
use App\Services\Order\Models\OrderRefund;

class StatsController extends BaseController
{
    // 每日交易数据统计
    public function transaction()
    {
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
        $todayRefundCount = OrderRefund::query()->where('created_at', '>=', date('Y-m-d'))->count();

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
            ->where('status', Order::STATUS_PAID)
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

            // 今日客单价 = 今日支付总额 / 今日已支付订单数量
            // 昨日客单价 = 昨日支付总额 / 昨日已支付订单数量
        ]);
    }

    //交易排名
    public function transactionTop(Request $request)
    {
        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 10);
        $offset = ($page - 1) * $size;

        $statAt = $request->input('start_at');
        $endAt = $request->input('end_at');
        if (!$statAt || !$endAt || Carbon::parse($statAt)->gte($endAt)) {
            return $this->error(__('参数错误'));
        }

        $statAt = Carbon::parse($statAt)->toDateTimeLocalString();
        $endAt = Carbon::parse($endAt)->toDateTimeLocalString();

        $tableOrders = TableConstant::TABLE_ORDERS;
        $tableOrderGoods = TableConstant::TABLE_ORDER_GOODS;

        $sql = <<<SQL
SELECT
        {$tableOrderGoods}.goods_id,
        {$tableOrderGoods}.goods_name,
        count({$tableOrders}.id) AS orders_count,
        sum({$tableOrders}.charge) AS orders_paid_sum
FROM {$tableOrders}
INNER JOIN {$tableOrderGoods}
    ON {$tableOrderGoods}.oid = {$tableOrders}.id
WHERE {$tableOrders}.status = 9 and {$tableOrders}.created_at between '{$statAt}' and '{$endAt}'
GROUP BY  {$tableOrderGoods}.goods_id,{$tableOrderGoods}.goods_name
ORDER BY  orders_paid_sum desc
limit {$offset},{$size};
SQL;

        $result = DB::select($sql);

        return $this->successData($result);
    }
}
