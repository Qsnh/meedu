<?php

use Illuminate\Database\Seeder;

class BackendMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $map = [
            '公告' => '公告列表界面',
            'VIP会员' => 'VIP列表界面',
            '订单列表' => '订单列表',
            '会员' => '会员列表',
            '课程' => '课程列表界面',
            '课程评论' => '课程评论列表界面',
            '视频评论' => '视频评论列表界面',
            '视频' => '视频列表界面',
            '友情链接' => '友情链接列表',
            '推广链接' => '推广链接首页',
            '首页导航' => '首页导航首页',
            '管理员' => '管理员界面',
            '角色' => '管理员角色界面',
            '权限' => '管理员权限界面',
            '后台菜单' => '后台菜单界面',
        ];

        $menus = [
            [
                'name' => '主面板',
                'url' => '',
                'permission_id' => 0,
                'children' => [
                    [
                        'name' => '主面板',
                        'url' => '/backend/dashboard',
                        'permission_id' => 0,
                    ],
                ],
            ],
            [
                'name' => '运营',
                'url' => '',
                'permission_id' => 0,
                'children' => [
                    [
                        'name' => '公告',
                        'url' => '/backend/announcement',
                    ],
                    [
                        'name' => 'VIP会员',
                        'url' => '/backend/role',
                    ],
                    [
                        'name' => '友情链接',
                        'url' => '/backend/link',
                    ],
                    [
                        'name' => '推广链接',
                        'url' => '/backend/adfrom',
                    ],
                    [
                        'name' => '课程评论',
                        'url' => '/backend/course/comment/index',
                    ],
                    [
                        'name' => '视频评论',
                        'url' => '/backend/video/comment/index',
                    ],
                ],
            ],
            [
                'name' => '财务',
                'url' => '',
                'permission_id' => 0,
                'children' => [
                    [
                        'name' => '订单列表',
                        'url' => '/backend/orders',
                    ],
                ],
            ],
            [
                'name' => '会员',
                'url' => '',
                'permission_id' => 0,
                'children' => [
                    [
                        'name' => '会员',
                        'url' => '/backend/member',
                    ],
                ],
            ],
            [
                'name' => '视频',
                'url' => '',
                'permission_id' => 0,
                'children' => [
                    [
                        'name' => '课程',
                        'url' => '/backend/course',
                    ],
                    [
                        'name' => '视频',
                        'url' => '/backend/video',
                    ],
                ],
            ],
            [
                'name' => '系统',
                'url' => '',
                'permission_id' => 0,
                'children' => [
                    [
                        'name' => '全站配置',
                        'url' => '/backend/setting',
                    ],
                    [
                        'name' => '管理员',
                        'url' => '/backend/administrator',
                    ],
                    [
                        'name' => '角色',
                        'url' => '/backend/administrator_role',
                    ],
                    [
                        'name' => '权限',
                        'url' => '/backend/administrator_permission',
                    ],
                    [
                        'name' => '后台菜单',
                        'url' => '/backend/administrator_menu',
                    ],
                    [
                        'name' => '首页导航',
                        'url' => '/backend/nav',
                    ],
                    [
                        'name' => '插件',
                        'url' => '/backend/addons/index',
                    ],
                ],
            ],
        ];


        foreach ($menus as $index => $menu) {
            $data = [
                'name' => $menu['name'],
                'url' => $menu['url'],
                'permission_id' => $menu['permission_id'],
                'order' => $index,
                'parent_id' => 0,
            ];
            $node = \App\Models\AdministratorMenu::where('name', $data['name'])->where('url', $data['url'])->first();
            if (! $node) {
                $node = \App\Models\AdministratorMenu::create($data);
            }

            foreach ($menu['children'] as $i => $item) {
                if (\App\Models\AdministratorMenu::where('name', $item['name'])->where('url', $item['url'])->exists()) {
                    continue;
                }
                $data = $item;
                if (! isset($data['permission_id'])) {
                    $displayName = isset($map[$item['name']]) ? $map[$item['name']] : $item['name'];
                    $permission = \App\Models\AdministratorPermission::where('display_name', $displayName)->first();
                    $data['permission_id'] = $permission ? $permission->id : 0;
                }
                $data['order'] = $i;
                $data['parent_id'] = $node->id;
                \App\Models\AdministratorMenu::create($data);
            }
        }
    }
}
