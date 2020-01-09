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
use App\Exceptions\ServiceException;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Base\Services\ConfigService;
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
        if (!Hash::check($oldPassword, $user->password)) {
            throw new ServiceException(__('old_password_error'));
        }
        $user->password = Hash::make($newPassword);
        $user->save();
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
        $user->password = Hash::make($password);
        $user->save();
    }

    /**
     * @param int $userId
     * @param string $password
     */
    public function changePassword(int $userId, string $password): void
    {
        User::whereId($userId)->update(['password' => Hash::make($password)]);
    }

    /**
     * @param string $avatar
     * @param string $name
     *
     * @return array
     */
    public function createWithoutMobile(string $avatar = '', string $name = ''): array
    {
        $user = User::create([
            'avatar' => $avatar ?: $this->configService->getMemberDefaultAvatar(),
            'nick_name' => $name ?? Str::random(16),
            'mobile' => mt_rand(2, 9) . mt_rand(1000, 9999) . mt_rand(1000, 9999),
            'password' => Hash::make(Str::random(16)),
            'is_lock' => $this->configService->getMemberLockStatus(),
            'is_active' => $this->configService->getMemberActiveStatus(),
            'role_id' => 0,
            'role_expired_at' => Carbon::now(),
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
            'password' => Hash::make($password),
            'is_lock' => $this->configService->getMemberLockStatus(),
            'is_active' => $this->configService->getMemberActiveStatus(),
            'role_id' => 0,
            'role_expired_at' => Carbon::now(),
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
        $list = $query->forPage($page, $pageSize)->get();
        // 标记为已读
        foreach ($list as $item) {
            $item->markAsRead();
        }
        $list = $list->toArray();
        $list = array_column($list, 'data');

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
     * @param array $promoCode
     */
    public function updateInviteUserId(int $id, array $promoCode): void
    {
        $inviteConfig = $this->configService->getMemberInviteConfig();
        $expiredDays = $inviteConfig['effective_days'] ?? 0;
        User::whereId($id)->update([
            'invite_user_id' => $promoCode['user_id'],
            'invite_user_expired_at' => $expiredDays ? Carbon::now()->addDays($expiredDays) : null,
        ]);
        /**
         * @var $userInviteBalanceService UserInviteBalanceService
         */
        $userInviteBalanceService = app()->make(UserInviteBalanceServiceInterface::class);
        $userInviteBalanceService->createInvite($promoCode['user_id'], $promoCode['invited_user_reward']);
    }
}
