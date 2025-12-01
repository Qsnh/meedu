<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Businesses\BusinessState;
use App\Events\UserRegisterEvent;
use App\Exceptions\ServiceException;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Events\UserVideoWatchedEvent;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserWatchStat;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Member\Models\UserVideoWatchRecord;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    protected $configService;

    protected $businessState;

    public function __construct(ConfigServiceInterface $configService, BusinessState $businessState)
    {
        $this->configService = $configService;
        $this->businessState = $businessState;
    }

    public function findMobile(string $mobile): array
    {
        $user = User::query()->where('mobile', $mobile)->first();

        return $user ? $user->toArray() : [];
    }

    public function passwordLogin(string $mobile, string $password): array
    {
        $user = User::query()->where('mobile', $mobile)->first();
        if (!$user) {
            return [];
        }
        if (!Hash::check($password, $user['password'])) {
            return [];
        }

        return $user->toArray();
    }

    public function changePassword(int $userId, string $password): void
    {
        User::query()->where('id', $userId)->update([
            'password' => Hash::make($password),
            'is_password_set' => 1,
        ]);
    }

    public function createWithoutMobile(string $avatar = '', string $name = '', array $extra = []): array
    {
        $user = User::query()
            ->create([
                'avatar' => $avatar ?: $this->configService->getMemberDefaultAvatar(),
                'nick_name' => $name ?? Str::random(16),
                'mobile' => random_int(2, 9) . random_int(1000, 9999) . random_int(1000, 9999),
                'password' => Hash::make(Str::random(16)),
                'is_lock' => $this->configService->getMemberLockStatus(),
                'is_active' => $this->configService->getMemberActiveStatus(),
                'role_id' => 0,
                'role_expired_at' => Carbon::now(),
                'is_set_nickname' => 0,
            ]);

        event(new UserRegisterEvent($user['id'], $extra));

        return $user->toArray();
    }

    public function createWithMobile(string $mobile, string $password, string $nickname, string $avatar = '', array $extra = []): array
    {
        $user = User::query()
            ->create([
                'avatar' => $avatar ?: $this->configService->getMemberDefaultAvatar(),
                'nick_name' => $nickname ?: Str::random(12),
                'mobile' => $mobile,
                'password' => Hash::make($password ?: Str::random(10)),
                'is_lock' => $this->configService->getMemberLockStatus(),
                'is_active' => $this->configService->getMemberActiveStatus(),
                'role_id' => 0,
                'role_expired_at' => Carbon::now(),
                'is_set_nickname' => $nickname ? 1 : 0,
                'is_password_set' => $password ? 1 : 0,
            ]);

        event(new UserRegisterEvent($user['id'], $extra));

        return $user->toArray();
    }

    public function changeMobile(int $userId, string $mobile): void
    {
        if ($this->findMobile($mobile)) {
            throw new ServiceException(__('手机号已存在'));
        }
        User::query()->where('id', $userId)->update(['mobile' => $mobile]);
    }

    /**
     * @param int $userId
     * @param string $avatar
     * @return void
     */
    public function updateAvatar(int $userId, string $avatar): void
    {
        User::query()->where('id', $userId)->update(['avatar' => $avatar]);
    }

    /**
     * @param int $userId
     * @param string $nickname
     * @throws ServiceException
     */
    public function updateNickname(int $userId, string $nickname): void
    {
        $user = $this->find($userId);
        if ((int)$user['is_set_nickname'] === 1) {
            throw new ServiceException(__('当前用户已配置昵称'));
        }
        $exists = User::query()->where('id', '<>', $userId)->where('nick_name', $nickname)->exists();
        if ($exists) {
            throw new ServiceException(__('昵称已经存在'));
        }

        User::query()
            ->where('id', $userId)
            ->update([
                'nick_name' => $nickname,
                'is_set_nickname' => 1,
            ]);
    }

    /**
     * @param int $id
     * @param array $with
     *
     * @return array
     */
    public function find(int $id, array $with = []): array
    {
        return User::query()->with($with)->findOrFail($id)->toArray();
    }

    /**
     * @param int $userId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function messagePaginate(int $userId, int $page, int $pageSize): array
    {
        $query = User::query()
            ->findOrFail($userId)
            ->notifications()
            ->latest();

        $total = $query->count();
        $data = $query->forPage($page, $pageSize)->get();
        $list = $data->toArray();

        return compact('list', 'total');
    }

    /**
     * @param int $userId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function getUserBuyCourses(int $userId, int $page, int $pageSize): array
    {
        $query = UserCourse::query()->where('user_id', $userId)->orderByDesc('created_at');

        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();

        return compact('list', 'total');
    }

    /**
     * @param int $userId
     * @param int $courseId
     * @return bool
     */
    public function hasCourse(int $userId, int $courseId): bool
    {
        return UserCourse::query()->where('user_id', $userId)->where('course_id', $courseId)->exists();
    }

    public function getUserBuyVideosIn(int $userId, array $videoIds): array
    {
        return UserVideo::query()
            ->select(['video_id'])
            ->where('user_id', $userId)
            ->whereIn('video_id', $videoIds)
            ->get()
            ->pluck('video_id')
            ->toArray();
    }

    /**
     * @param int $userId
     * @param int $videoId
     * @return bool
     */
    public function hasVideo(int $userId, int $videoId): bool
    {
        return UserVideo::query()->where('user_id', $userId)->where('video_id', $videoId)->exists();
    }

    /**
     * @param int $userId
     * @param int $roleId
     * @param string $expiredAt
     */
    public function changeRole(int $userId, int $roleId, string $expiredAt): void
    {
        User::query()
            ->where('id', $userId)
            ->update([
                'role_id' => $roleId,
                'role_expired_at' => Carbon::parse($expiredAt)->toDateTimeLocalString(),
            ]);
    }

    /**
     * @param int $userId
     * @param string $id
     */
    public function notificationMarkAsRead(int $userId, string $id): void
    {
        $notification = User::query()->find($userId)->notifications()->whereId($id)->first();
        $notification && $notification->markAsRead();
    }

    /**
     * @param int $userId
     */
    public function notificationMarkAllAsRead(int $userId): void
    {
        User::query()->find($userId)->unreadNotifications->markAsRead();
    }

    /**
     * 未读消息数量
     *
     * @param integer $userId
     * @return int
     */
    public function unreadNotificationCount(int $userId): int
    {
        return User::query()->find($userId)->unreadNotifications->count();
    }

    /**
     * @param int $userId
     * @param int $courseId
     * @return int
     */
    public function likeACourse(int $userId, int $courseId): int
    {
        $record = UserLikeCourse::query()
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();
        if ($record) {
            $record->delete();
            return 0;
        }

        UserLikeCourse::query()
            ->create([
                'user_id' => $userId,
                'course_id' => $courseId,
            ]);
        return 1;
    }

    /**
     * @param int $userId
     * @param int $courseId
     * @return bool
     */
    public function likeCourseStatus(int $userId, int $courseId): bool
    {
        return UserLikeCourse::query()
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    }

    /**
     * 用户视频观看记录
     *
     * @param int $userId
     * @param int $courseId
     * @param int $videoId
     * @param int $duration
     * @param bool $isWatched
     */
    public function recordUserVideoWatch(int $userId, int $courseId, int $videoId, int $duration, bool $isWatched): void
    {
        $record = UserVideoWatchRecord::query()
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('video_id', $videoId)
            ->first();

        $isEmitWatchedEvent = false;

        if ($record) {
            if ($record->watched_at === null && $record->watch_seconds <= $duration) {
                // 如果有记录[没看完 && 当前时间超过已记录的时间]
                $data = ['watch_seconds' => $duration];
                if ($isWatched) {
                    $data['watched_at'] = Carbon::now();
                    $isEmitWatchedEvent = true;
                }
                $record->fill($data)->save();
            }
        } else {
            UserVideoWatchRecord::query()
                ->create([
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'video_id' => $videoId,
                    'watch_seconds' => $duration,
                    'watched_at' => $isWatched ? Carbon::now() : null,
                ]);
            $isEmitWatchedEvent = $isWatched;
        }

        $isEmitWatchedEvent && event(new UserVideoWatchedEvent($userId, $videoId));
    }

    /**
     * 获取用户视频观看记录
     * @param int $userId
     * @param int $courseId
     * @return array
     */
    public function getUserVideoWatchRecords(int $userId, int $courseId): array
    {
        $records = UserVideoWatchRecord::query()->where('user_id', $userId)->where('course_id', $courseId)->get();
        return $records->toArray();
    }

    /**
     * @param int $id
     * @param string $ip
     */
    public function setRegisterIp(int $id, string $ip): void
    {
        User::query()->where('id', $id)->update(['register_ip' => $ip]);
    }

    /**
     * @param int $id
     * @param string $area
     */
    public function setRegisterArea(int $id, string $area): void
    {
        $area && User::query()->where('id', $id)->update(['register_area' => $area]);
    }

    /**
     * 重置会员过期用户
     *
     * @return int
     */
    public function resetRoleExpiredUsers(): int
    {
        return User::query()
            ->where('role_expired_at', '<=', Carbon::now())
            ->update(['role_id' => 0, 'role_expired_at' => null]);
    }

    /**
     * 用户视频观看时间统计
     * @param int $userId
     * @param int $seconds
     */
    public function watchStatSave(int $userId, int $seconds): void
    {
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $record = UserWatchStat::query()
            ->where('user_id', $userId)
            ->where('year', $year)
            ->where('month', $month)
            ->where('day', $day)
            ->first();
        if ($record) {
            // todo 用户量大了之后此处频繁写入MySQL的CPU会飚高
            UserWatchStat::query()
                ->where('id', $record['id'])
                ->where('seconds', $record['seconds'])
                ->update(['seconds' => $record['seconds'] + $seconds]);
        } else {
            UserWatchStat::query()
                ->create([
                    'user_id' => $userId,
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                    'seconds' => $seconds,
                ]);
        }
    }


    public function inviteCount(int $userId): int
    {
        return User::query()->where('invite_user_id', $userId)->count();
    }

    public function clearVideoWatchRecords(int $videoId)
    {
        UserVideoWatchRecord::query()->where('video_id', $videoId)->delete();
    }
}
