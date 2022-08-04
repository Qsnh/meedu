<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

use Carbon\Carbon;
use App\Constant\TableConstant;
use Illuminate\Support\Facades\DB;
use App\Meedu\ServiceV2\Models\User;
use App\Meedu\ServiceV2\Models\UserCourse;
use App\Meedu\ServiceV2\Models\UserDeleteJob;
use App\Services\Member\Models\UserLikeCourse;
use App\Meedu\ServiceV2\Models\CourseUserRecord;
use App\Meedu\ServiceV2\Models\UserVideoWatchRecord;
use App\Services\Member\Notifications\SimpleMessageNotification;

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

    public function getPerUserLearnedCourseLastVideo(int $userId, array $courseIds): array
    {
        $table = TableConstant::TABLE_USER_VIDEO_WATCH_RECORDS;
        $courseIds = implode(',', $courseIds);
        $sql = <<<SQL
select 
    `u1`.`id`,`u1`.`user_id`,`u1`.`course_id`,`u1`.`video_id`,`u1`.`watch_seconds`,`u1`.`watched_at`,`u1`.`created_at`,`u1`.`updated_at` 
from {$table} as `u1`
where
    `u1`.`id` = (
        select
            `u2`.`id`
        from {$table} as `u2` 
        where
            `u2`.`course_id` = `u1`.`course_id` and `u2`.`user_id` = ? and `u2`.`course_id` in ({$courseIds})
        order by `u2`.`updated_at` desc limit 1
    )
SQL;
        $result = DB::select($sql, [$userId]);
        return array_map('get_object_vars', $result);
    }

    public function getPerUserLearnedCourseVideoCount(int $userId, array $courseIds): array
    {
        return UserVideoWatchRecord::query()
            ->select([
                'course_id',
                DB::raw('count(*) as `learned_count`'),//已学课时数量
            ])
            ->where('user_id', $userId)
            ->when($courseIds, function ($query) use ($courseIds) {
                $query->whereIn('course_id', $courseIds);
            })
            ->whereNotNull('watched_at')
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

    public function findUserDeleteJobUnHandle(int $userId): array
    {
        $job = UserDeleteJob::query()->where('user_id', $userId)->where('is_handle', 0)->first();
        return $job ? $job->toArray() : [];
    }

    public function findUserOrFail(int $userId, array $fields): array
    {
        return User::query()->select($fields)->where('id', $userId)->firstOrFail()->toArray();
    }

    public function storeUserDeleteJob(int $userId, string $mobile): int
    {
        $job = UserDeleteJob::create([
            'user_id' => $userId,
            'mobile' => $mobile,
            'is_handle' => 0,
            'submit_at' => Carbon::now()->toDateTimeLocalString(),
            'expired_at' => Carbon::now()->addDays(7)->toDateTimeLocalString(),
        ]);
        return $job['id'];
    }

    public function deleteUserDeleteJobUnHandle(int $userId): int
    {
        return UserDeleteJob::query()->where('user_id', $userId)->where('is_handle', 0)->delete();
    }

    public function notifySimpleMessage(int $userId, string $message)
    {
        $user = User::query()->where('id', $userId)->firstOrFail();
        $user->notify(new SimpleMessageNotification($message));
    }
}
