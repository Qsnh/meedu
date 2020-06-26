<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use App\Models\Administrator;
use App\Models\AdministratorMenu;
use App\Constant\BackendApiConstant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Backend\LoginRequest;

class LoginController extends BaseController
{
    const GUARD = 'administrator';

    public function login(LoginRequest $request)
    {
        ['username' => $username, 'password' => $password] = $request->filldata();
        $admin = Administrator::whereEmail($username)->first();
        if (!$admin) {
            return $this->error(BackendApiConstant::ADMINISTRATOR_NOT_EXISTS);
        }
        if (!Hash::check($password, $admin->password)) {
            return $this->error(BackendApiConstant::LOGIN_PASSWORD_ERROR);
        }

        if ($admin->is_ban_login === 1) {
            return $this->error(__('administrator cant login'));
        }

        // jwt登录
        $token = Auth::guard(self::GUARD)->login($admin);

        // 登录日志
        $admin->last_login_ip = $request->getClientIp();
        $admin->last_login_date = Carbon::now();
        $admin->login_times++;
        $admin->save();

        return $this->successData(compact('token'));
    }

    public function user()
    {
        $admin = Auth::guard(self::GUARD)->user();

        $permissions = $admin->permissions();
        $admin['permissions'] = $permissions;

        return $this->successData($admin);
    }

    public function menus()
    {
        $menus = AdministratorMenu::query()
            ->select(['id', 'parent_id', 'name as title', 'url as key', 'icon', 'permission', 'sort', 'is_super'])
            ->where('parent_id', 0)
            ->orderBy('sort')
            ->get()
            ->toArray();

        $data = [];

        $admin = Auth::guard(self::GUARD)->user();
        if (!$admin->isSuper()) {
            // 非超级管理员，需要根据权限生成菜单
            $permissions = $admin->permissions();
            foreach ($menus as $menu) {
                $children = AdministratorMenu::query()
                    ->select(['id', 'parent_id', 'name as title', 'url as key', 'icon', 'permission', 'sort', 'is_super'])
                    ->where('parent_id', $menu['id'])
                    ->orderBy('sort')
                    ->get()
                    ->toArray();

                if (!$children) {
                    $data[] = $menu;
                    continue;
                }

                $childrenData = [];
                foreach ($children as $item) {
                    if (($item['is_super'] ?? 0) === 1) {
                        continue;
                    }
                    $per = $item['permission'] ?? '';
                    if ($per === '' || isset($permissions[$per])) {
                        $childrenData[] = $item;
                        continue;
                    }
                }

                if (!$childrenData) {
                    continue;
                }

                $menu['children'] = $childrenData;
                $data[] = $menu;
            }
        } else {
            // 超管返回全部菜单
            foreach ($menus as $menu) {
                $children = AdministratorMenu::query()
                    ->select(['id', 'parent_id', 'name as title', 'url as key', 'icon', 'permission', 'sort', 'is_super'])
                    ->where('parent_id', $menu['id'])
                    ->orderBy('sort')
                    ->get()
                    ->toArray();
                if ($children) {
                    $menu['children'] = $children;
                }
                $data[] = $menu;
            }
        }

        return $this->successData([
            'menus' => $data,
        ]);
    }
}
