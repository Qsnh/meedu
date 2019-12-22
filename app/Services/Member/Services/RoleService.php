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

use App\Services\Member\Models\Role;
use App\Services\Member\Models\UserJoinRoleRecord;

class RoleService
{
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
     * @param int $userId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public function userRolePaginate(int $userId, int $page, int $pageSize): array
    {
        $query = UserJoinRoleRecord::with(['user', 'role'])
            ->whereUserId($userId)
            ->orderByDesc('created_at');
        $total = $query->count();
        $list = $query->forPage($page, $pageSize)->get()->toArray();
        return compact('total', 'list');
    }
}
