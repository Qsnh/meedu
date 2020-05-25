<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Businesses\BusinessState;
use App\Events\UserRegisterEvent;
use App\Constant\FrontendConstant;
use App\Exceptions\ServiceException;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\UserVideoWatchedEvent;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Member\Models\UserVideoWatchRecord;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\UserInviteBalanceServiceInterface;

class UserService implements UserServiceInterface
{
    /**
     * @var ConfigService
     */
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
            throw new ServiceException(__('old_password_error'));
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
            'is_password_set' => FrontendConstant::PASSWORD_SET,
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
     *
     * @return array
     */
    public function createWithMobile(string $mobile, string $password, string $nickname): array
    {
        $user = User::create([
            'avatar' => $this->configService->getMemberDefaultAvatar(),
            'nick_name' => $nickname ?: Str::random(16),
            'mobile' => $mobile,
            'password' => Hash::make($password ?: Str::random(10)),
            'is_lock' => $this->configService->getMemberLockStatus(),
            'is_active' => $this->configService->getMemberActiveStatus(),
            'role_id' => 0,
            'role_expired_at' => Carbon::now(),
            'is_set_nickname' => $nickname ? 1 : 0,
        ]);

        event(new UserRegisterEvent($user->id));

        return $user->toArray();
    }

    /**
     * @param string $mobile
     * @throws ServiceException
     */
    public function bindMobile(string $mobile): void
    {
        $user = User::findOrFail(Auth::id());
        if (!$this->businessState->isNeedBindMobile($user->toArray())) {
            throw new ServiceException(__('cant bind mobile'));
        }
        if (User::whereMobile($mobile)->exists()) {
            throw new ServiceException(__('mobile has exists'));
        }
        $user->mobile = $mobile;
        $user->save();
    }

    /**
     * @param $userId
     * @param $avatar
     */
    public function updateAvatar(int $userId, string $avatar): void
    {
        User::whereId($userId)->update(['avatar' => $avatar]);
    }

    /**
     * @param int $userId
     * @param string $nickname
     * @throws ServiceException
     */
    public function updateNickname(int $userId, string $nickname): void
    {
        $user = $this->find($userId);
        if ($user['is_set_nickname'] === FrontendConstant::YES) {
            throw new ServiceException(__('current user cant set nickname'));
        }
        $exists = User::where('id', '<>', $userId)->whereNickName($nickname)->exists();
        if ($exists) {
            throw new ServiceException(__('nick_name.unique'));
        }
        User::whereId($userId)->update([
            'nick_name' => $nickname,
            'is_set_nickname' => FrontendConstant::YES,
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

    /**
     * @return array
     */
    public function getUserBuyAllVideosId(): array
    {
        return UserVideo::query()->select(['video_id'])->whereUserId(Auth::id())->orderByDesc('created_at')->get()->toArray();
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
     * @param int $id
     * @param $userId
     * @param int $reward
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updateInviteUserId(int $id, $userId, $reward = 0): void
    {
        $inviteConfig = $this->configService->getMemberInviteConfig();
        $expiredDays = $inviteConfig['effective_days'] ?? 0;
        User::whereId($id)->update([
            'invite_user_id' => $userId,
            'invite_user_expired_at' => $expiredDays ? Carbon::now()->addDays($expiredDays) : null,
        ]);
        /**
         * @var $userInviteBalanceService UserInviteBalanceService
         */
        $userInviteBalanceService = app()->make(UserInviteBalanceServiceInterface::class);
        $userInviteBalanceService->createInvite($userId, $reward);
    }

    /**
     * @return int
     */
    public function getCurrentUserCourseCount(): int
    {
        return (int)UserCourse::whereUserId(Auth::id())->count();
    }

    /**
     * @return int
     */
    public function getCurrentUserVideoCount(): int
    {
        return (int)UserVideo::whereUserId(Auth::id())->count();
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

        if ($record && $record->watched_at === null && $record->watch_seconds < $duration) {
            // 如果有记录，那么在没有看完的情况下继续记录
            $data = ['watch_seconds' => $duration];
            $isWatched && $data['watched_at'] = Carbon::now();
            $record->fill($data)->save();
        } else {
            UserVideoWatchRecord::create([
                'user_id' => $userId,
                'course_id' => $courseId,
                'video_id' => $videoId,
                'watch_seconds' => $duration,
                'watched_at' => $isWatched ? Carbon::now() : null,
            ]);
        }

        // 视频看完event
        $isWatched && event(new UserVideoWatchedEvent($userId, $videoId));
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
     */
    public function setUsedPromoCode(int $id): void
    {
        User::query()->where('id', $id)->update(['is_used_promo_code' => 1]);
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
        $area && User::query()->where('id', $id)->update(['register_ip' => $area]);
    }
}
