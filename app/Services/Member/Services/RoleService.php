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
use Illuminate\Support\Facades\DB;
use App\Services\Member\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Services\Member\Models\UserJoinRoleRecord;
use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;

class RoleService implements RoleServiceInterface
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function all(): array
    {
        return Role::show()->orderBy('weight')->get()->toArray();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function find(int $id): array
    {
        return Role::show()->findOrFail($id)->toArray();
    }

    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return array
     */
    public function userRolePaginate(int $page, int $pageSize): array
    {
        $query = UserJoinRoleRecord::with(['user', 'role'])
            ->whereUserId(Auth::id())
            ->orderByDesc('created_at');
        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();

        return compact('total', 'list');
    }

    /**
     * @param array $user
     * @param array $role
     * @param int $charge
     */
    public function userJoinRole(array $user, array $role, int $charge): void
    {
        // 当前用户是免费会员
        DB::transaction(function () use ($user, $role, $charge) {
            $now = Carbon::now();
            $expiredAt = (clone $now)->addDays($role['expire_days']);
            // 创建购买记录
            UserJoinRoleRecord::create([
                'user_id' => $user['id'],
                'role_id' => $role['id'],
                'charge' => $charge,
                'started_at' => $now,
                'expired_at' => $expiredAt,
            ]);
            // 修改user表
            $this->userService->changeRole($user['id'], $role['id'], $expiredAt->toString());
        });
    }

    public function userContinueRole(array $user, array $role, int $charge): void
    {
        // 用户续费套餐
        DB::transaction(function () use ($user, $role, $charge) {
            $startAt = Carbon::parse($user['role_expired_at']);
            $startAt = $startAt->gt(Carbon::now()) ? $startAt : Carbon::now();
            $expiredAt = (clone $startAt)->addDays($role['expire_days']);
            // 创建购买记录
            UserJoinRoleRecord::create([
                'user_id' => $user['id'],
                'role_id' => $role['id'],
                'charge' => $charge,
                'started_at' => $startAt,
                'expired_at' => $expiredAt,
            ]);
            // 修改user表
            $this->userService->changeRole($user['id'], $role['id'], $expiredAt->toString());
        });
    }
}
