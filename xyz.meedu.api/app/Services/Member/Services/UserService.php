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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\UserVideoWatchedEvent;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserProfile;
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

    /**
     * @return array
     */
    public function currentUser(): array
    {
        return $this->find(Auth::id(), ['role']);
    }

    /**
     * @param string $mobile
     *
     * @return array
     */
    public function findMobile(string $mobile): array
    {
        $user = User::whereMobile($mobile)->first();

        return $user ? $user->toArray() : [];
    }

    /**
     * @param string $nickname
     * @return array
     */
    public function findNickname(string $nickname): array
    {
        $user = User::whereNickName($nickname)->first();

        return $user ? $user->toArray() : [];
    }

    /**
     * @param string $mobile
     * @param string $password
     *
     * @return array
     */
    public function passwordLogin(string $mobile, string $password): array
    {
        $user = User::whereMobile($mobile)->first();
        if (!$user) {
            return [];
        }
        if (!Hash::check($password, $user->password)) {
            return [];
        }

        return $user->toArray();
    }

    /**
     * @param int $userId
     * @param string $oldPassword
     * @param string $newPassword
     *
     * @throws \Exception
     */
    public function resetPassword(int $userId, string $oldPassword, string $newPassword): void
    {
        $user = User::findOrFail($userId);
        if ($oldPassword && !Hash::check($oldPassword, $user->password)) {
            throw new ServiceException(__('原密码错误'));
        }
        $this->changePassword($user->id, $newPassword);
    }

    /**
     * 找回密码
     *
     * @param $mobile string 手机号
     * @param $password string 新密码
     */
    public function findPassword(string $mobile, string $password): void
    {
        $user = User::whereMobile($mobile)->firstOrFail();
        $this->changePassword($user->id, $password);
    }

    /**
     * @param int $userId
     * @param string $password
     */
    public function changePassword(int $userId, string $password): void
    {
        User::whereId($userId)->update([
            'password' => Hash::make($password),
            'is_password_set' => 1,
        ]);
    }

    /**
     * @param string $avatar
     * @param string $name
     * @return array
     * @throws \Exception
     */
    public function createWithoutMobile(string $avatar = '', string $name = ''): array
    {
        $user = User::create([
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

        event(new UserRegisterEvent($user->id));

        return $user->toArray();
    }

    /**
     * @param string $mobile
     * @param string $password
     * @param string $nickname
     * @param string $avatar
     * @return array
     */
    public function createWithMobile(string $mobile, string $password, string $nickname, string $avatar = ''): array
    {
        $user = User::create([
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

        event(new UserRegisterEvent($user->id));

        return $user->toArray();
    }

    /**
     * @param string $mobile
     * @param int $userId
     *
     * @throws ServiceException
     */
    public function bindMobile(string $mobile, int $userId): void
    {
        $user = User::query()->where('id', $userId)->first();

        if (!$this->businessState->isNeedBindMobile($user->toArray())) {
            throw new ServiceException(__('该账号已绑定手机号'));
        }

        if (User::query()->where('mobile', $mobile)->exists()) {
            throw new ServiceException(__('手机号已存在'));
        }

        $user->mobile = $mobile;
        $user->save();
    }

    /**
     * 更换手机号
     *
     * @param integer $userId
     * @param string $mobile
     * @return void
     */
    public function changeMobile(int $userId, string $mobile): void
    {
        if ($this->findMobile($mobile)) {
            throw new ServiceException(__('手机号已存在'));
        }
        User::query()->where('id', $userId)->update(['mobile' => $mobile]);
    }

    /**
     * @param $userId
     * @param $avatar
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
     * @param array $ids
     * @param array $with
     *
     * @return array
     */
    public function getList(array $ids, array $with = []): array
    {
        return User::with($with)->whereIn('id', $ids)->get()->toArray();
    }

    /**
     * @param int $id
     * @param array $with
     *
     * @return array
     */
    public function find(int $id, array $with = []): array
    {
        return User::with($with)->findOrFail($id)->toArray();
    }

    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return array
     */
    public function messagePaginate(int $page, int $pageSize): array
    {
        $query = User::find(Auth::id())->notifications()->latest();

        $total = $query->count();
        $data = $query->forPage($page, $pageSize)->get();
        $list = $data->toArray();

        return compact('list', 'total');
    }

    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return array
     */
    public function getUserBuyCourses(int $page, int $pageSize): array
    {
        $query = UserCourse::query()->whereUserId(Auth::id())->orderByDesc('created_at');

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
        return UserCourse::whereUserId($userId)->whereCourseId($courseId)->exists();
    }

    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return array
     */
    public function getUserBuyVideos(int $page, int $pageSize): array
    {
        $query = UserVideo::query()->whereUserId(Auth::id())->orderByDesc('created_at');

        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();

        return compact('list', 'total');
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
        return UserVideo::whereUserId($userId)->whereVideoId($videoId)->exists();
    }

    /**
     * @param int $userId
     * @param int $roleId
     * @param string $expiredAt
     */
    public function changeRole(int $userId, int $roleId, string $expiredAt): void
    {
        User::whereId($userId)->update([
            'role_id' => $roleId,
            'role_expired_at' => Carbon::parse($expiredAt),
        ]);
    }

    /**
     * @param array $nicknames
     * @return array
     */
    public function getUsersInNicknames(array $nicknames): array
    {
        return User::whereIn('nick_name', $nicknames)->get(['id', 'nick_name'])->keyBy('nick_name')->toArray();
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function inviteUsers(int $page, int $pageSize): array
    {
        $query = User::whereInviteUserId(Auth::id())->orderByDesc('id');
        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();

        return compact('list', 'total');
    }

    /**
     * @param int $userId
     * @return int
     */
    public function getUserCourseCount(int $userId): int
    {
        return (int)UserCourse::query()->where('user_id', $userId)->count();
    }

    /**
     * @param int $userId
     * @return int
     */
    public function getUserVideoCount(int $userId): int
    {
        return (int)UserVideo::query()->where('user_id', $userId)->count();
    }

    /**
     * @param int $userId
     * @param int $inc
     */
    public function inviteBalanceInc(int $userId, int $inc): void
    {
        User::find($userId)->increment('invite_balance', $inc);
    }

    /**
     * @param int $userId
     * @param string $id
     */
    public function notificationMarkAsRead(int $userId, string $id): void
    {
        $notification = User::find($userId)->notifications()->whereId($id)->first();
        $notification && $notification->markAsRead();
    }

    /**
     * @param int $userId
     */
    public function notificationMarkAllAsRead(int $userId): void
    {
        User::find($userId)->unreadNotifications->markAsRead();
    }

    /**
     * 未读消息数量
     *
     * @param integer $userId
     * @return int
     */
    public function unreadNotificationCount(int $userId): int
    {
        return (int)User::find($userId)->unreadNotifications->count();
    }

    /**
     * @param int $userId
     * @param int $courseId
     * @return int
     */
    public function likeACourse(int $userId, int $courseId): int
    {
        $record = UserLikeCourse::whereUserId($userId)->whereCourseId($courseId)->first();
        if ($record) {
            $record->delete();
            return 0;
        }
        UserLikeCourse::create([
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
        return UserLikeCourse::whereUserId($userId)->whereCourseId($courseId)->exists();
    }

    /**
     * @param int $userId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function userLikeCoursesPaginate(int $userId, int $page, int $pageSize): array
    {
        $query = UserLikeCourse::whereUserId($userId)->orderByDesc('id')->forPage($page, $pageSize);

        $total = $query->count();
        $list = $query->get()->toArray();

        return compact('list', 'total');
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
            UserVideoWatchRecord::create([
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
     * 获取课程的最新一条观看记录
     * @param int $userId
     * @param int $courseId
     * @return array
     */
    public function getLatestRecord(int $userId, int $courseId): array
    {
        $record = UserVideoWatchRecord::query()->where('user_id', $userId)->where('course_id', $courseId)->orderByDesc('updated_at')->first();
        return $record ? $record->toArray() : [];
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
            UserWatchStat::create([
                'user_id' => $userId,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'seconds' => $seconds,
            ]);
        }
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getProfile(int $userId): array
    {
        $profile = UserProfile::query()->where('user_id', $userId)->first();
        return $profile ? $profile->toArray() : [];
    }

    /**
     * @param int $userId
     * @param array $profileData
     */
    public function saveProfile(int $userId, array $profileData): void
    {
        $updateData = [];
        foreach (UserProfile::EDIT_COLUMNS as $column) {
            if (!isset($profileData[$column])) {
                continue;
            }
            if ($profileData[$column] !== null) {
                $updateData[$column] = $profileData[$column];
            }
        }

        $profile = UserProfile::query()->where('user_id', $userId)->first();
        if ($profile) {
            $profile->fill($updateData)->save();
        } else {
            $updateData['user_id'] = $userId;
            UserProfile::create($updateData);
        }
    }

    public function getUserWatchStatForYear(int $userId, int $year): int
    {
        return (int)UserWatchStat::query()
            ->where('user_id', $userId)
            ->where('year', $year)
            ->sum('seconds');
    }

    public function getUserWatchStatForMonth(int $userId, int $year, int $month): int
    {
        return (int)UserWatchStat::query()
            ->where('user_id', $userId)
            ->where('year', $year)
            ->where('month', $month)
            ->sum('seconds');
    }

    /**
     * @param int $userId
     * @param int $year
     * @param int $month
     * @param int $day
     * @return int
     */
    public function getUserWatchStatForDay(int $userId, int $year, int $month, int $day): int
    {
        return (int)UserWatchStat::query()
            ->where('user_id', $userId)
            ->where('year', $year)
            ->where('month', $month)
            ->where('day', $day)
            ->sum('seconds');
    }

    /**
     * @param int $userId
     * @return int
     */
    public function inviteCount(int $userId): int
    {
        return (int)User::query()->where('invite_user_id', $userId)->count();
    }

    /**
     * @param int $videoId
     */
    public function clearVideoWatchRecords(int $videoId)
    {
        UserVideoWatchRecord::query()->where('video_id', $videoId)->delete();
    }
}
