<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

use Illuminate\Support\Facades\DB;
use App\Meedu\ServiceV2\Models\UserCourse;
use App\Services\Member\Models\UserLikeCourse;
use App\Meedu\ServiceV2\Models\CourseUserRecord;
use App\Meedu\ServiceV2\Models\UserVideoWatchRecord;

class UserDao implements UserDaoInterface
{
    public function getUserCoursePaginate(int $userId, int $page, int $size): array
    {
        $data = UserCourse::query()
            ->select(['course_id', 'user_id', 'charge', 'created_at'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate($size, ['*'], null, $page);

        $total = $data->total();
        $data = $data->items();

        return compact('total', 'data');
    }

    public function getUserCourses(int $userId, array $courseIds): array
    {
        return UserCourse::query()
            ->select(['course_id', 'user_id', 'charge', 'created_at'])
            ->where('user_id', $userId)
            ->when($courseIds, function ($query) use ($courseIds) {
                $query->whereIn('course_id', $courseIds);
            })
            ->get()
            ->toArray();
    }

    public function getUserCourseWatchRecordsChunk(int $userId, array $courseIds): array
    {
        return CourseUserRecord::query()
            ->select([
                'id', 'course_id', 'user_id', 'is_watched', 'watched_at', 'progress', 'created_at', 'updated_at',
            ])
            ->where('user_id', $userId)
            ->when($courseIds, function ($query) use ($courseIds) {
                $query->whereIn('course_id', $courseIds);
            })
            ->get()
            ->toArray();
    }

    public function getPerUserLearnedCourseVideoCount(int $userId, array $courseIds): array
    {
        return UserVideoWatchRecord::query()
            ->select([
                'course_id',
                DB::raw('max(updated_at) as `updated_at`'),
                DB::raw('count(*) as `learned_count`'),//已学课时
            ])
            ->where('user_id', $userId)
            ->when($courseIds, function ($query) use ($courseIds) {
                $query->whereIn('course_id', $courseIds);
            })
            ->groupBy('course_id')
            ->get()
            ->toArray();
    }

    public function getUserLearnedCoursePaginate(int $userId, int $page, int $size): array
    {
        $data = CourseUserRecord::query()
            ->select([
                'id', 'course_id', 'user_id', 'is_watched', 'watched_at', 'progress',
                'created_at', 'updated_at',
            ])
            ->where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->paginate($size, ['*'], null, $page);

        $total = $data->total();
        $data = $data->items();

        return compact('total', 'data');
    }

    public function getUserLikeCoursePaginate(int $userId, int $page, int $size): array
    {
        $data = UserLikeCourse::query()
            ->select(['course_id', 'user_id', 'created_at'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate($size, ['*'], null, $page);

        $total = $data->total();
        $data = $data->items();

        return compact('total', 'data');
    }
}
