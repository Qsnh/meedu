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
use App\Meedu\ServiceV2\Models\Socialite;
use App\Meedu\ServiceV2\Models\UserCourse;
use App\Meedu\ServiceV2\Models\UserDeleteJob;
use App\Services\Member\Models\UserLikeCourse;
use App\Meedu\ServiceV2\Models\UserLoginRecord;
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

    public function getUserDeleteJobUnHandle(int $limit): array
    {
        return UserDeleteJob::query()
            ->where('is_handle', 0)
            ->orderBy('id')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function deleteUserRelateData(int $userId): void
    {
        $tables = [
            TableConstant::TABLE_PROMO_CODES,//邀请码表[v4.8之后用户不再生成此表数据]兼容老数据
            TableConstant::TABLE_USER_CREDIT_RECORDS,//用户积分[credit1]变动表
            TableConstant::TABLE_USER_JOIN_ROLE_RECORDS,//用户VIP变更记录表
            TableConstant::TABLE_USER_LIKE_COURSES,//用户收藏的录播课表
            TableConstant::TABLE_USER_LOGIN_RECORDS,//用户登录记录表
            TableConstant::TABLE_USER_PROFILES,//用户详细资料表
            TableConstant::TABLE_USER_REMARKS,//用户备注表[CRM]
            TableConstant::TABLE_USER_TAG,//用户标签关联表
            TableConstant::TABLE_USER_VIDEO,//用户购买的录播视频表[v4.7之后用户不可以单独购买录播视频]兼容老数据
            TableConstant::TABLE_USER_VIDEO_WATCH_RECORDS,//用户录播视频观看进度表
            TableConstant::TABLE_VIDEO_COMMENTS,//录播视频评论表
            TableConstant::TABLE_COURSE_COMMENTS,//录播课评论表
            TableConstant::TABLE_COURSE_USER_RECORDS,//用户录播课观看进度表
            TableConstant::TABLE_USER_COURSE,//用户已购录播课表
            TableConstant::TABLE_USER_SOCIALITE,//三方登录记录表
        ];
        foreach ($tables as $tableName) {
            DB::table($tableName)->where('user_id', $userId)->delete();
        }
    }

    public function destroyUser(int $userId): int
    {
        return User::query()->where('id', $userId)->delete();
    }

    public function changeUserDeleteJobsHandled(array $ids): int
    {
        return UserDeleteJob::query()->whereIn('id', $ids)->update(['is_handle' => 1]);
    }

    public function findUser(array $filter, array $fields): array
    {
        $user = User::query()
            ->select($fields)
            ->when(isset($filter['id']), function ($query) use ($filter) {
                $query->where('id', $filter['id']);
            })
            ->when(isset($filter['mobile']), function ($query) use ($filter) {
                $query->where('mobile', $filter['mobile']);
            })
            ->first();
        return $user ? $user->toArray() : [];
    }

    public function storeUserLoginRecord(int $userId, string $token, string $platform, string $ua, string $ip): int
    {
        $tokenPayload = token_payload($token);

        $record = UserLoginRecord::create([
            'user_id' => $userId,
            'platform' => $platform,
            'ip' => $ip,
            'created_at' => Carbon::now()->toDateTimeLocalString(),
            'ua' => $ua,
            'token' => $token,
            'iss' => $tokenPayload['iss'],
            'exp' => $tokenPayload['exp'],
            'jti' => $tokenPayload['jti'],
        ]);

        return $record['id'];
    }

    public function updateUserLastLoginId(int $userId, int $loginId): int
    {
        return User::query()->where('id', $userId)->update(['last_login_id' => $loginId]);
    }

    public function findUserLoginRecordOrFail(int $id): array
    {
        return UserLoginRecord::query()->where('id', $id)->firstOrCreate()->toArray();
    }

    public function logoutUserLoginRecord(int $userId, string $jti): int
    {
        return UserLoginRecord::query()->where('jti', $jti)->where('user_id', $userId)->update(['is_logout' => 1]);
    }

    public function findSocialiteRecord(string $app, string $appId): array
    {
        $record = Socialite::query()->where('app', $app)->where('app_user_id', $appId)->first();
        return $record ? $record->toArray() : [];
    }

    public function findSocialiteRecordByUnionId(string $unionId): array
    {
        $record = Socialite::query()->where('union_id', $unionId)->first();
        return $record ? $record->toArray() : [];
    }

    public function findUserSocialites(int $userId): array
    {
        return Socialite::query()->where('user_id', $userId)->get()->toArray();
    }

    public function storeSocialiteRecord(int $userId, string $app, string $appId, array $data, string $unionId): int
    {
        $record = Socialite::create([
            'user_id' => $userId,
            'app' => $app,
            'app_user_id' => $appId,
            'data' => serialize($data),
            'union_id' => $unionId,
        ]);
        return $record['id'];
    }
}
