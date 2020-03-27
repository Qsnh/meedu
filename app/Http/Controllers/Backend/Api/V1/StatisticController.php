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

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;

class StatisticController extends BaseController
{

    // 用户注册统计
    public function userRegister(Request $request)
    {
        $startAt = Carbon::parse($request->input('start_at', Carbon::now()->subMonths(1)));
        $endAt = Carbon::parse($request->input('end_at', Carbon::now()->subDays(1)));
        $users = User::select(['created_at'])->whereBetween('created_at', [$startAt, $endAt])->get();
        $data = [];
        while ($startAt->lt($endAt)) {
            $data[$startAt->format('Y-m-d')] = 0;
            $startAt->addDays(1);
        }
        foreach ($users as $user) {
            $date = $user->created_at->format('Y-m-d');
            $data[$date]++;
        }
        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }

    public function orderCreated(Request $request)
    {
        $startAt = Carbon::parse($request->input('start_at', Carbon::now()->subMonths(1)));
        $endAt = Carbon::parse($request->input('end_at', Carbon::now()->subDays(1)));
        $users = Order::select(['created_at'])->whereBetween('created_at', [$startAt, $endAt])->get();
        $data = [];
        while ($startAt->lt($endAt)) {
            $data[$startAt->format('Y-m-d')] = 0;
            $startAt->addDays(1);
        }
        foreach ($users as $user) {
            $date = $user->created_at->format('Y-m-d');
            $data[$date]++;
        }
        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }
}
