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
                'url' => '/backend/member/\d+',
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

            // 运营[邮件群发]
            [
                'display_name' => '邮件群发界面',
                'slug' => 'backend.subscription.email',
                'method' => 'GET',
                'url' => '/backend/subscription_email',
                'description' => '',
            ],
            [
                'display_name' => '邮件群发任务的提交',
                'slug' => 'backend.subscription.email',
                'method' => 'POST',
                'url' => '/backend/subscription_email',
                'description' => '',
            ],

            // FAQ分类
            [
                'display_name' => 'FAQ分类列表界面',
                'slug' => 'backend.faq.category.index',
                'method' => 'GET',
                'url' => '/backend/faq/category',
                'description' => '',
            ],
            [
                'display_name' => 'FAQ分类创建界面',
                'slug' => 'backend.faq.category.create',
                'method' => 'GET',
                'url' => '/backend/faq/category/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新FAQ分类',
                'slug' => 'backend.faq.category.create',
                'method' => 'POST',
                'url' => '/backend/faq/category/create',
                'description' => '',
            ],
            [
                'display_name' => 'FAQ分类编辑界面',
                'slug' => 'backend.faq.category.edit',
                'method' => 'GET',
                'url' => '/backend/faq/category/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的FAQ分类',
                'slug' => 'backend.faq.category.edit',
                'method' => 'PUT',
                'url' => '/backend/faq/category/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除FAQ分类',
                'slug' => 'backend.faq.category.destroy',
                'method' => 'GET',
                'url' => '/backend/faq/category/\d+/delete',
                'description' => '',
            ],

            // FAQ文章
            [
                'display_name' => 'FAQ文章列表界面',
                'slug' => 'backend.faq.article.index',
                'method' => 'GET',
                'url' => '/backend/faq/article',
                'description' => '',
            ],
            [
                'display_name' => 'FAQ文章创建界面',
                'slug' => 'backend.faq.article.create',
                'method' => 'GET',
                'url' => '/backend/faq/article/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新FAQ文章',
                'slug' => 'backend.faq.article.create',
                'method' => 'POST',
                'url' => '/backend/faq/article/create',
                'description' => '',
            ],
            [
                'display_name' => 'FAQ文章编辑界面',
                'slug' => 'backend.faq.article.edit',
                'method' => 'GET',
                'url' => '/backend/faq/article/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的FAQ文章',
                'slug' => 'backend.faq.article.edit',
                'method' => 'PUT',
                'url' => '/backend/faq/article/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除FAQ文章',
                'slug' => 'backend.faq.article.destroy',
                'method' => 'GET',
                'url' => '/backend/faq/article/\d+/delete',
                'description' => '',
            ],

            // 电子书
            [
                'display_name' => '电子书列表',
                'slug' => 'backend.book.index',
                'method' => 'GET',
                'url' => '/backend/book',
                'description' => '',
            ],
            [
                'display_name' => '电子书创建界面',
                'slug' => 'backend.book.create',
                'method' => 'GET',
                'url' => '/backend/book/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新电子书',
                'slug' => 'backend.book.create',
                'method' => 'POST',
                'url' => '/backend/book/create',
                'description' => '',
            ],
            [
                'display_name' => '电子书编辑界面',
                'slug' => 'backend.book.edit',
                'method' => 'GET',
                'url' => '/backend/book/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的电子书',
                'slug' => 'backend.book.edit',
                'method' => 'PUT',
                'url' => '/backend/book/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除电子书',
                'slug' => 'backend.book.destroy',
                'method' => 'GET',
                'url' => '/backend/book/\d+/delete',
                'description' => '',
            ],

            // 电子书章节
            [
                'display_name' => '电子书章节列表',
                'slug' => 'backend.book.chapter.index',
                'method' => 'GET',
                'url' => '/backend/book/\d+/chapter',
                'description' => '',
            ],
            [
                'display_name' => '电子书章节创建界面',
                'slug' => 'backend.book.chapter.create',
                'method' => 'GET',
                'url' => '/backend/book/\d+/chapter/create',
                'description' => '',
            ],
            [
                'display_name' => '是否可以创建新电子书章节',
                'slug' => 'backend.book.chapter.create',
                'method' => 'POST',
                'url' => '/backend/book/\d+/chapter/create',
                'description' => '',
            ],
            [
                'display_name' => '电子书章节编辑界面',
                'slug' => 'backend.book.chapter.edit',
                'method' => 'GET',
                'url' => '/backend/book/\d+/chapter/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '是否可以保存编辑后的电子书章节',
                'slug' => 'backend.book.chapter.edit',
                'method' => 'PUT',
                'url' => '/backend/book/\d+/chapter/\d+/edit',
                'description' => '',
            ],
            [
                'display_name' => '删除电子书章节',
                'slug' => 'backend.book.chapter.destroy',
                'method' => 'GET',
                'url' => '/backend/book/\d+/chapter/\d+/delete',
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
        ];

        foreach ($permissions as $permission) {
            $exists = \App\Models\AdministratorPermission::where('display_name', $permission['display_name'])->exists();
            ! $exists && \App\Models\AdministratorPermission::create($permission);
        }
    }
}
