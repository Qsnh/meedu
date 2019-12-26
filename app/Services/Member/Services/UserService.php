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
use App\Exceptions\ServiceException;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Base\Services\ConfigService;

class UserService
{
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
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
     * @param int    $userId
     * @param string $oldPassword
     * @param string $newPassword
     *
     * @throws \Exception
     */
    public function resetPassword(int $userId, string $oldPassword, string $newPassword): void
    {
        $user = User::findOrFail($userId);
        if (! Hash::check($oldPassword, $user->password)) {
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
            'mobile' => mt_rand(2, 9).mt_rand(1000, 9999).mt_rand(1000, 9999),
            'password' => Hash::make(Str::random(16)),
            'is_lock' => $this->configService->getMemberLockStatus(),
            'is_active' => $this->configService->getMemberActiveStatus(),
            'role_id' => 0,
            'role_expired_at' => Carbon::now(),
        ]);
        // todo 用户创建事件
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
        // todo 用户创建事件
        return $user->toArray();
    }

    /**
     * @param $userId
     * @param $mobile
     *
     * @throws ServiceException
     */
    public function bindMobile($userId, $mobile): void
    {
        $user = User::findOrFail($userId);
        if (substr($user->mobile, 0, 1) == 1) {
            throw new ServiceException(__('cant bind mobile'));
        }
        $user->mobile = $mobile;
        $user->save();
    }

    /**
     * @param $userId
     * @param $avatar
     */
    public function updateAvatar($userId, $avatar): void
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
     * @param int   $id
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
        $list = $query->forPage($page, $pageSize)->get()->toArray();

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
     * @param int    $userId
     * @param int    $roleId
     * @param string $expiredAt
     */
    public function changeRole(int $userId, int $roleId, string $expiredAt): void
    {
        User::whereId($userId)->update([
            'role_id' => $roleId,
            'role_expired_at' => Carbon::parse($expiredAt),
        ]);
    }
}
