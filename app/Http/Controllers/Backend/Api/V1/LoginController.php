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

        return $this->successData($admin);
    }

    public function menus()
    {
        $menus = [
            [
                'title' => '首页',
                'key' => 'Home',
                'icon' => 'icon-monitor',
            ],
            [
                'title' => '运营',
                'key' => 'operator',
                'icon' => 'icon-grid-2',
                'children' => [
                    [
                        'title' => '公告',
                        'key' => 'Announcement',
                        'permission' => 'announcement',
                    ],
                    [
                        'title' => 'VIP会员',
                        'key' => 'Role',
                        'permission' => 'role',
                    ],
                    [
                        'title' => '友情链接',
                        'key' => 'Link',
                        'permission' => 'link',
                    ],
                    [
                        'title' => '幻灯片',
                        'key' => 'Slider',
                        'permission' => 'slider',
                    ],
                    [
                        'title' => '首页推荐',
                        'key' => 'IndexBanner',
                        'permission' => 'indexBanner',
                    ],
                    [
                        'title' => '推广链接',
                        'key' => 'AdFrom',
                        'permission' => 'ad_from',
                    ],
                    [
                        'title' => '课程评论',
                        'key' => 'CourseComment',
                        'permission' => 'course_comment',
                    ],
                    [
                        'title' => '视频评论',
                        'key' => 'VideoComment',
                        'permission' => 'video_comment',
                    ],
                    [
                        'title' => '统计工具',
                        'key' => 'Statistic',
                    ],
                ],
            ],
            [
                'title' => '财务',
                'key' => 'finance',
                'icon' => 'icon-paper',
                'children' => [
                    [
                        'title' => '订单列表',
                        'key' => 'Order',
                        'permission' => 'order',
                    ],
                    [
                        'title' => '优惠码',
                        'key' => 'PromoCode',
                        'permission' => 'promoCode',
                    ],
                    [
                        'title' => '邀请余额提现',
                        'key' => 'InviteBalanceWithdrawOrders',
                        'permission' => 'member.inviteBalance.withdrawOrders',
                    ],
                ],
            ],
            [
                'title' => '用户',
                'key' => 'members',
                'icon' => 'icon-head',
                'children' => [
                    [
                        'title' => '用户',
                        'key' => 'Member',
                        'permission' => 'member',
                    ],
                ],
            ],
            [
                'title' => '视频',
                'key' => 'videomanage',
                'icon' => 'icon-video',
                'children' => [
                    [
                        'title' => '分类',
                        'key' => 'CourseCategory',
                        'permission' => 'courseCategory',
                    ],
                    [
                        'title' => '课程',
                        'key' => 'Course',
                        'permission' => 'course',
                    ],
                    [
                        'title' => '视频',
                        'key' => 'Video',
                        'permission' => 'video',
                    ],
                ],
            ],
            [
                'title' => '系统',
                'key' => 'system',
                'icon' => 'icon-cog',
                'children' => [
                    [
                        'title' => '配置',
                        'key' => 'Setting',
                        'permission' => 'setting',
                    ],
                    [
                        'title' => '管理员',
                        'key' => 'Administrator',
                        'permission' => 'administrator',
                    ],
                    [
                        'title' => '管理员角色',
                        'key' => 'AdministratorRole',
                        'permission' => 'administrator_role',
                    ],
                    [
                        'title' => '首页导航',
                        'key' => 'Nav',
                        'permission' => 'nav',
                    ],
                    [
                        'title' => '插件',
                        'key' => 'Addons',
                        'super' => 1,
                    ],
                ],
            ],
        ];

        $data = [];

        $admin = Auth::guard(self::GUARD)->user();
        if (!$admin->isSuper()) {
            // 非超级管理员，需要根据权限生成菜单
            $permissions = $admin->permissions();
            foreach ($menus as $menu) {
                if (!isset($menu['children'])) {
                    $data[] = $menu;
                    continue;
                }

                $children = $menu['children'];
                $children = array_filter($children, function ($item) use ($permissions) {
                    if (isset($item['super'])) {
                        return false;
                    }
                    $per = $item['permission'] ?? '';
                    if (!$per) {
                        return true;
                    }
                    return isset($permissions[$per]);
                });
                sort($children);

                if (count($children) === 0) {
                    continue;
                }

                $menu['children'] = $children;
                $data[] = $menu;
            }
        } else {
            // 超管返回全部菜单
            $data = $menus;
        }

        return $this->successData([
            'menus' => $data,
        ]);
    }
}
