<?php

use Illuminate\Database\Seeder;

class AdministratorPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            // 后台菜单
            [
                'display_name' => '后台菜单界面',
                'slug' => 'backend.administrator_menu.index',
                'method' => 'GET',
                'url' => '/backend/administrator_menu',
                'description' => '',
            ],
            [
                'display_name' => '后台菜单创建界面',
                'slug' => 'backend.administrator_menu.create',
                'method' => 'GET',
                'url' => '/backend/administrator_menu/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新后台菜单',
                'slug' => 'backend.administrator_menu.create',
                'method' => 'POST',
                'url' => '/backend/administrator_menu/create',
                'description' => '',
            ],
            [
                'display_name' => '后台菜单编辑界面',
                'slug' => 'backend.administrator_menu.edit',
                'method' => 'GET',
                'url' => '/backend/administrator_menu/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的后台菜单',
                'slug' => 'backend.administrator_menu.edit',
                'method' => 'PUT',
                'url' => '/backend/administrator_menu/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除后台菜单',
                'slug' => 'backend.administrator_menu.destroy',
                'method' => 'GET',
                'url' => '/backend/administrator_menu/\d+/delete',
                'description' => '',
            ],
            [
                'display_name' => '后台菜单批量修改',
                'slug' => 'backend.administrator_menu.save_change',
                'method' => 'GET',
                'url' => '/backend/administrator_menu/change/save',
                'description' => '',
            ],

            // 管理员权限
            [
                'display_name' => '管理员权限界面',
                'slug' => 'backend.administrator_permission.index',
                'method' => 'GET',
                'url' => '/backend/administrator_permission',
                'description' => '',
            ],
            [
                'display_name' => '管理员权限创建界面',
                'slug' => 'backend.administrator_permission.create',
                'method' => 'GET',
                'url' => '/backend/administrator_permission/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新管理员权限',
                'slug' => 'backend.administrator_permission.create',
                'method' => 'POST',
                'url' => '/backend/administrator_permission/create',
                'description' => '',
            ],
            [
                'display_name' => '管理员权限编辑界面',
                'slug' => 'backend.administrator_permission.edit',
                'method' => 'GET',
                'url' => '/backend/administrator_permission/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的管理员权限',
                'slug' => 'backend.administrator_permission.edit',
                'method' => 'PUT',
                'url' => '/backend/administrator_permission/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除管理员权限',
                'slug' => 'backend.administrator_permission.destroy',
                'method' => 'GET',
                'url' => '/backend/administrator_permission/\d+/destroy',
                'description' => '',
            ],

            // 管理员角色
            [
                'display_name' => '管理员角色界面',
                'slug' => 'backend.administrator_role.index',
                'method' => 'GET',
                'url' => '/backend/administrator_role',
                'description' => '',
            ],
            [
                'display_name' => '管理员角色创建界面',
                'slug' => 'backend.administrator_role.create',
                'method' => 'GET',
                'url' => '/backend/administrator_role/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新管理员角色',
                'slug' => 'backend.administrator_role.create',
                'method' => 'POST',
                'url' => '/backend/administrator_role/create',
                'description' => '',
            ],
            [
                'display_name' => '管理员角色编辑界面',
                'slug' => 'backend.administrator_role.edit',
                'method' => 'GET',
                'url' => '/backend/administrator_role/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的管理员角色',
                'slug' => 'backend.administrator_role.edit',
                'method' => 'PUT',
                'url' => '/backend/administrator_role/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除管理员角色',
                'slug' => 'backend.administrator_role.destroy',
                'method' => 'GET',
                'url' => '/backend/administrator_role/\d+/destroy',
                'description' => '',
            ],
            [
                'display_name' => '管理员角色授权页面',
                'slug' => 'backend.administrator_role.permission',
                'method' => 'GET',
                'url' => '/backend/administrator_role/\d+/permission',
                'description' => '',
            ],
            [
                'display_name' => '管理员角色授权保存',
                'slug' => 'backend.administrator_role.permission',
                'method' => 'POST',
                'url' => '/backend/administrator_role/\d+/permission',
                'description' => '',
            ],

            // 管理员
            [
                'display_name' => '管理员界面',
                'slug' => 'backend.administrator.index',
                'method' => 'GET',
                'url' => '/backend/administrator',
                'description' => '',
            ],
            [
                'display_name' => '管理员创建界面',
                'slug' => 'backend.administrator.create',
                'method' => 'GET',
                'url' => '/backend/administrator/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新管理员',
                'slug' => 'backend.administrator.create',
                'method' => 'POST',
                'url' => '/backend/administrator/create',
                'description' => '',
            ],
            [
                'display_name' => '管理员编辑界面',
                'slug' => 'backend.administrator.edit',
                'method' => 'GET',
                'url' => '/backend/administrator/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的管理员',
                'slug' => 'backend.administrator.edit',
                'method' => 'PUT',
                'url' => '/backend/administrator/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除管理员',
                'slug' => 'backend.administrator.destroy',
                'method' => 'GET',
                'url' => '/backend/administrator/\d+/destroy',
                'description' => '',
            ],

            // 全站配置
            [
                'display_name' => '全站配置',
                'slug' => 'backend.setting.index',
                'method' => 'GET',
                'url' => '/backend/setting',
                'description' => '',
            ],
            [
                'display_name' => '全站配置保存',
                'slug' => 'backend.setting.index',
                'method' => 'POST',
                'url' => '/backend/setting',
                'description' => '',
            ],

            // 课程
            [
                'display_name' => '课程列表界面',
                'slug' => 'backend.course.index',
                'method' => 'GET',
                'url' => '/backend/course',
                'description' => '',
            ],
            [
                'display_name' => '课程创建界面',
                'slug' => 'backend.course.create',
                'method' => 'GET',
                'url' => '/backend/course/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新课程',
                'slug' => 'backend.course.create',
                'method' => 'POST',
                'url' => '/backend/course/create',
                'description' => '',
            ],
            [
                'display_name' => '课程编辑界面',
                'slug' => 'backend.course.edit',
                'method' => 'GET',
                'url' => '/backend/course/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的课程',
                'slug' => 'backend.course.edit',
                'method' => 'PUT',
                'url' => '/backend/course/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除课程',
                'slug' => 'backend.course.destroy',
                'method' => 'GET',
                'url' => '/backend/course/\d+/delete',
                'description' => '',
            ],

            // 课程评论
            [
                'display_name' => '课程评论列表界面',
                'slug' => 'backend.course.comment.index',
                'method' => 'GET',
                'url' => '/backend/course/comment/index',
                'description' => '',
            ],
            [
                'display_name' => '删除课程评论',
                'slug' => 'backend.course.comment.destroy',
                'method' => 'GET',
                'url' => '/backend/course/comment/\d+/destroy',
                'description' => '',
            ],

            // 视频
            [
                'display_name' => '视频列表界面',
                'slug' => 'backend.video.index',
                'method' => 'GET',
                'url' => '/backend/video',
                'description' => '',
            ],
            [
                'display_name' => '视频创建界面',
                'slug' => 'backend.video.create',
                'method' => 'GET',
                'url' => '/backend/video/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新视频',
                'slug' => 'backend.video.create',
                'method' => 'POST',
                'url' => '/backend/video/create',
                'description' => '',
            ],
            [
                'display_name' => '视频编辑界面',
                'slug' => 'backend.video.edit',
                'method' => 'GET',
                'url' => '/backend/video/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的视频',
                'slug' => 'backend.video.edit',
                'method' => 'PUT',
                'url' => '/backend/video/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除视频',
                'slug' => 'backend.video.destroy',
                'method' => 'GET',
                'url' => '/backend/video/\d+/delete',
                'description' => '',
            ],

            // 视频评论
            [
                'display_name' => '视频评论列表界面',
                'slug' => 'backend.video.comment.index',
                'method' => 'GET',
                'url' => '/backend/video/comment/index',
                'description' => '',
            ],
            [
                'display_name' => '删除视频评论',
                'slug' => 'backend.video.comment.destroy',
                'method' => 'GET',
                'url' => '/backend/video/comment/\d+/destroy',
                'description' => '',
            ],

            // 财务[充值]
            [
                'display_name' => '订单列表',
                'slug' => 'backend.orders',
                'method' => 'GET',
                'url' => '/backend/orders',
                'description' => '',
            ],

            // 会员管理
            [
                'display_name' => '会员列表',
                'slug' => 'backend.member.index',
                'method' => 'GET',
                'url' => '/backend/member',
                'description' => '',
            ],
            [
                'display_name' => '会员详情',
                'slug' => 'backend.member.show',
                'method' => 'GET',
                'url' => '/backend/member/\d+/show',
                'description' => '',
            ],
            [
                'display_name' => '添加会员页面',
                'slug' => 'backend.member.create',
                'method' => 'GET',
                'url' => '/backend/member/create',
                'description' => '',
            ],
            [
                'display_name' => '添加会员',
                'slug' => 'backend.member.create',
                'method' => 'POST',
                'url' => '/backend/member/create',
                'description' => '',
            ],

            // 公告
            [
                'display_name' => '公告列表界面',
                'slug' => 'backend.announcement.index',
                'method' => 'GET',
                'url' => '/backend/announcement',
                'description' => '',
            ],
            [
                'display_name' => '公告创建界面',
                'slug' => 'backend.announcement.create',
                'method' => 'GET',
                'url' => '/backend/announcement/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新公告',
                'slug' => 'backend.announcement.create',
                'method' => 'POST',
                'url' => '/backend/announcement/create',
                'description' => '',
            ],
            [
                'display_name' => '公告编辑界面',
                'slug' => 'backend.announcement.edit',
                'method' => 'GET',
                'url' => '/backend/announcement/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的公告',
                'slug' => 'backend.announcement.edit',
                'method' => 'PUT',
                'url' => '/backend/announcement/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除公告',
                'slug' => 'backend.announcement.destroy',
                'method' => 'GET',
                'url' => '/backend/announcement/\d+/delete',
                'description' => '',
            ],

            // VIP管理
            [
                'display_name' => 'VIP列表界面',
                'slug' => 'backend.role.index',
                'method' => 'GET',
                'url' => '/backend/role',
                'description' => '',
            ],
            [
                'display_name' => 'VIP创建界面',
                'slug' => 'backend.role.create',
                'method' => 'GET',
                'url' => '/backend/role/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新VIP',
                'slug' => 'backend.role.create',
                'method' => 'POST',
                'url' => '/backend/role/create',
                'description' => '',
            ],
            [
                'display_name' => 'VIP编辑界面',
                'slug' => 'backend.role.edit',
                'method' => 'GET',
                'url' => '/backend/role/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的VIP',
                'slug' => 'backend.role.edit',
                'method' => 'PUT',
                'url' => '/backend/role/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除VIP',
                'slug' => 'backend.role.destroy',
                'method' => 'GET',
                'url' => '/backend/role/\d+/delete',
                'description' => '',
            ],

            // 友情链接
            [
                'display_name' => '友情链接列表',
                'slug' => 'backend.link.index',
                'method' => 'GET',
                'url' => '/backend/link',
                'description' => '',
            ],
            [
                'display_name' => '创建友情链接界面',
                'slug' => 'backend.link.create',
                'method' => 'GET',
                'url' => '/backend/link/create',
                'description' => '',
            ],
            [
                'display_name' => '创建友情链接',
                'slug' => 'backend.link.create',
                'method' => 'POST',
                'url' => '/backend/link/create',
                'description' => '',
            ],
            [
                'display_name' => '编辑友情链接界面',
                'slug' => 'backend.link.edit',
                'method' => 'GET',
                'url' => '/backend/link/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '保存友情链接的变动',
                'slug' => 'backend.link.edit',
                'method' => 'PUT',
                'url' => '/backend/link/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除友情链接',
                'slug' => 'backend.link.destroy',
                'method' => 'GET',
                'url' => '/backend/link/\d+/delete',
                'description' => '',
            ],
            
            // 推广链接
            [
                'display_name' => '推广链接首页',
                'slug' => 'backend.adfrom.index',
                'method' => 'GET',
                'url' => '/backend/adfrom',
                'description' => '',
            ],
            [
                'display_name' => '创建推广链接界面',
                'slug' => 'backend.adfrom.create',
                'method' => 'GET',
                'url' => '/backend/adfrom/create',
                'description' => '',
            ],
            [
                'display_name' => '创建推广链接',
                'slug' => 'backend.adfrom.create',
                'method' => 'POST',
                'url' => '/backend/adfrom/create',
                'description' => '',
            ],
            [
                'display_name' => '编辑推广链接界面',
                'slug' => 'backend.adfrom.edit',
                'method' => 'GET',
                'url' => '/backend/adfrom/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '保存推广链接的变动',
                'slug' => 'backend.adfrom.edit',
                'method' => 'PUT',
                'url' => '/backend/adfrom/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除推广链接',
                'slug' => 'backend.adfrom.destroy',
                'method' => 'GET',
                'url' => '/backend/adfrom/\d+/delete',
                'description' => '',
            ],
            [
                'display_name' => '查看推广链接推广效果',
                'slug' => 'backend.adfrom.number',
                'method' => 'GET',
                'url' => '/backend/adfrom/\d+/number',
                'description' => '',
            ],

            // 首页导航
            [
                'display_name' => '首页导航首页',
                'slug' => 'backend.nav.index',
                'method' => 'GET',
                'url' => '/backend/nav',
                'description' => '',
            ],
            [
                'display_name' => '创建首页导航界面',
                'slug' => 'backend.nav.create',
                'method' => 'GET',
                'url' => '/backend/nav/create',
                'description' => '',
            ],
            [
                'display_name' => '创建首页导航',
                'slug' => 'backend.nav.create',
                'method' => 'POST',
                'url' => '/backend/nav/create',
                'description' => '',
            ],
            [
                'display_name' => '编辑首页导航界面',
                'slug' => 'backend.nav.edit',
                'method' => 'GET',
                'url' => '/backend/nav/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '保存首页导航的变动',
                'slug' => 'backend.nav.edit',
                'method' => 'PUT',
                'url' => '/backend/nav/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除首页导航',
                'slug' => 'backend.nav.destroy',
                'method' => 'GET',
                'url' => '/backend/nav/\d+/delete',
                'description' => '',
            ],

            // 插件
            [
                'display_name' => '插件',
                'slug' => 'backend.addons.index',
                'method' => 'GET',
                'url' => '/backend/addons/index',
                'description' => '',
            ],
            [
                'display_name' => '插件generateProvidersMap',
                'slug' => 'backend.addons.generateProvidersMap',
                'method' => 'GET',
                'url' => '/backend/addons/generateProvidersMap',
                'description' => '',
            ],
        ];

        foreach ($permissions as $permission) {
            $exists = \App\Models\AdministratorPermission::where('slug', $permission['slug'])
                ->where('method', $permission['method'])
                ->exists();
            ! $exists && \App\Models\AdministratorPermission::create($permission);
        }
    }
}
