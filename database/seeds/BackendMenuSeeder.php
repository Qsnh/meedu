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
            '邮件群发' => '邮件群发界面',
            '订单列表' => '订单列表',
            '会员' => '会员列表',
            '课程' => '课程列表界面',
            '视频' => '视频列表界面',
            'FAQ分类' => 'FAQ分类列表界面',
            'FAQ文章' => 'FAQ文章列表界面',
            '电子书' => '电子书列表',
            '友情链接' => '友情链接列表',
            '推广链接' => '推广链接首页',
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
                        'name' => '邮件群发',
                        'url' => '/backend/subscription_email',
                    ],
                    [
                        'name' => '友情链接',
                        'url' => '/backend/link',
                    ],
                    [
                        'name' => '推广链接',
                        'url' => '/backend/adfrom',
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
                'name' => '电子书',
                'url' => '',
                'permission_id' => 0,
                'children' => [
                    [
                        'name' => '电子书',
                        'url' => '/backend/book',
                    ],
                ],
            ],
            [
                'name' => 'FAQ',
                'url' => '',
                'permission_id' => 0,
                'children' => [
                    [
                        'name' => 'FAQ分类',
                        'url' => '/backend/faq/category',
                    ],
                    [
                        'name' => 'FAQ文章',
                        'url' => '/backend/faq/article',
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
                        'permission_id' => -1,
                    ],
                    [
                        'name' => '管理员',
                        'url' => '/backend/administrator',
                        'permission_id' => -1,
                    ],
                    [
                        'name' => '角色',
                        'url' => '/backend/administrator_role',
                        'permission_id' => -1,
                    ],
                    [
                        'name' => '权限',
                        'url' => '/backend/administrator_permission',
                        'permission_id' => -1,
                    ],
                    [
                        'name' => '后台菜单',
                        'url' => '/backend/administrator_menu',
                        'permission_id' => -1,
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
            $node = \App\Models\AdministratorMenu::create($data);

            foreach ($menu['children'] as $i => $item) {
                $data = $item;
                if (! isset($data['permission_id'])) {
                    $permission = \App\Models\AdministratorPermission::whereDisplayName($map[$item['name']])->first();
                    $data['permission_id'] = $permission->id;
                }
                $data['order'] = $i;
                $data['parent_id'] = $node->id;
                \App\Models\AdministratorMenu::create($data);
            }
        }
    }
}
