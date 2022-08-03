<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserJoinRoleRecord;
use App\Services\Member\Models\UserVideoWatchRecord;

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATS,
            AdministratorLog::OPT_VIEW,
            compact('startAt', 'endAt')
        );

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATS,
            AdministratorLog::OPT_VIEW,
            compact('startAt', 'endAt')
        );

        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }

    public function orderPaidCount(Request $request)
    {
        $startAt = Carbon::parse($request->input('start_at', Carbon::now()->subMonths(1)));
        $endAt = Carbon::parse($request->input('end_at', Carbon::now()->subDays(1)));

        $orders = Order::select(['created_at'])
            ->where('status', Order::STATUS_PAID)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->get();

        $data = [];
        while ($startAt->lt($endAt)) {
            $data[$startAt->format('Y-m-d')] = 0;
            $startAt->addDays(1);
        }
        foreach ($orders as $item) {
            $date = $item->created_at->format('Y-m-d');
            $data[$date]++;
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATS,
            AdministratorLog::OPT_VIEW,
            compact('startAt', 'endAt')
        );

        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }

    public function orderPaidSum(Request $request)
    {
        $startAt = Carbon::parse($request->input('start_at', Carbon::now()->subMonths(1)));
        $endAt = Carbon::parse($request->input('end_at', Carbon::now()->subDays(1)));

        $orders = Order::select(['charge', 'status', 'created_at'])
            ->where('status', Order::STATUS_PAID)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->get();

        $data = [];
        while ($startAt->lt($endAt)) {
            $data[$startAt->format('Y-m-d')] = 0;
            $startAt->addDays(1);
        }
        foreach ($orders as $item) {
            $date = $item->created_at->format('Y-m-d');
            $data[$date] += $item->charge;
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATS,
            AdministratorLog::OPT_VIEW,
            compact('startAt', 'endAt')
        );

        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }

    public function courseSell(Request $request)
    {
        $courseId = $request->input('course_id');
        $startAt = Carbon::parse($request->input('start_at', Carbon::now()->subMonths(1)));
        $endAt = Carbon::parse($request->input('end_at', Carbon::now()->subDays(1)));

        $orders = UserCourse::query()
            ->where('course_id', $courseId)->select(['user_id', 'created_at'])
            ->whereBetween('created_at', [$startAt, $endAt])
            ->get();

        $data = [];
        while ($startAt->lt($endAt)) {
            $data[$startAt->format('Y-m-d')] = 0;
            $startAt->addDays(1);
        }

        foreach ($orders as $item) {
            $date = Carbon::parse($item->created_at)->format('Y-m-d');
            $data[$date]++;
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATS,
            AdministratorLog::OPT_VIEW,
            compact('startAt', 'endAt', 'courseId')
        );

        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }

    public function roleSell(Request $request)
    {
        $roleId = $request->input('role_id');
        $startAt = Carbon::parse($request->input('start_at', Carbon::now()->subMonths(1)));
        $endAt = Carbon::parse($request->input('end_at', Carbon::now()->subDays(1)));

        $orders = UserJoinRoleRecord::query()
            ->where('role_id', $roleId)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->get();

        $data = [];
        while ($startAt->lt($endAt)) {
            $data[$startAt->format('Y-m-d')] = 0;
            $startAt->addDays(1);
        }

        foreach ($orders as $item) {
            $date = $item->created_at->format('Y-m-d');
            $data[$date]++;
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATS,
            AdministratorLog::OPT_VIEW,
            compact('startAt', 'endAt', 'roleId')
        );

        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }

    public function videoWatchDuration(Request $request)
    {
        $videoId = $request->input('video_id');
        $startAt = Carbon::parse($request->input('start_at', Carbon::now()->subMonths(1)));
        $endAt = Carbon::parse($request->input('end_at', Carbon::now()->subDays(1)));

        $records = UserVideoWatchRecord::query()
            ->where('video_id', $videoId)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->get();

        $data = [];
        while ($startAt->lt($endAt)) {
            $data[$startAt->format('Y-m-d')] = 0;
            $startAt->addDays(1);
        }

        foreach ($records as $item) {
            $date = Carbon::parse($item->created_at)->format('Y-m-d');
            $data[$date] += $item->watch_seconds;
        }

        // 单位转换为小时
        $data = array_map(function ($val) {
            return $val / 60;
        }, $data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATS,
            AdministratorLog::OPT_VIEW,
            compact('startAt', 'endAt', 'videoId')
        );

        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }

    public function courseWatchDuration(Request $request)
    {
        $courseId = $request->input('course_id');
        $startAt = Carbon::parse($request->input('start_at', Carbon::now()->subMonths(1)));
        $endAt = Carbon::parse($request->input('end_at', Carbon::now()->subDays(1)));

        $records = UserVideoWatchRecord::query()
            ->where('course_id', $courseId)
            ->whereBetween('created_at', [$startAt, $endAt])
            ->get();

        $data = [];
        while ($startAt->lt($endAt)) {
            $data[$startAt->format('Y-m-d')] = 0;
            $startAt->addDays(1);
        }

        foreach ($records as $item) {
            $date = Carbon::parse($item->created_at)->format('Y-m-d');
            $data[$date] += $item->watch_seconds;
        }

        // 单位转换为小时
        $data = array_map(function ($val) {
            return $val / 60;
        }, $data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_STATS,
            AdministratorLog::OPT_VIEW,
            compact('startAt', 'endAt', 'courseId')
        );

        return $this->successData([
            'labels' => array_keys($data),
            'dataset' => array_values($data),
        ]);
    }
}
