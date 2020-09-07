<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Illuminate\Database\Seeder;

class AdministratorMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
                'title' => '微信公众号',
                'key' => 'mp_wechat',
                'icon' => 'icon-grid',
                'children' => [
                    [
                        'title' => '消息回复',
                        'key' => 'mpWechatMessageReply',
                        'permission' => 'mpWechatMessageReply',
                    ],
                    [
                        'title' => '菜单',
                        'key' => 'mpWechatMenu',
                        'permission' => 'mpWechat.menu',
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

        foreach ($menus as $index => $menu) {
            $sort = ($index + 1) * 10;
            $model = $this->create($menu, 0, $sort);
            $children = $menu['children'] ?? [];
            if (!$children) {
                continue;
            }
            foreach ($children as $i => $item) {
                $this->create($item, $model['id'], $sort * 10 + ($i + 1) * 10);
            }
        }
    }

    protected function create($menu, $parentId = 0, $sort = 0)
    {
        $exists = \App\Models\AdministratorMenu::query()->where('name', $menu['title'])->where('url', $menu['key'])->first();
        if ($exists) {
            return $exists;
        }
        return \App\Models\AdministratorMenu::create([
            'parent_id' => $parentId,
            'name' => $menu['title'],
            'url' => $menu['key'] ?? '',
            'permission' => $menu['permission'] ?? '',
            'icon' => $menu['icon'] ?? '',
            'is_super' => $menu['super'] ?? 0,
            'sort' => $sort,
        ]);
    }
}
