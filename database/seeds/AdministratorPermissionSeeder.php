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
            // 视频上传
            [
                'group_name' => '视频',
                'display_name' => '腾讯云视频上传',
                'slug' => 'video.token.tencent',
                'method' => 'POST',
                'url' => 'video/token/tencent',
            ],
            [
                'group_name' => '视频',
                'display_name' => '阿里云视频上传',
                'slug' => 'video.token.aliyun.refresh',
                'method' => 'POST',
                'url' => 'video/token/aliyun/refresh',
            ],
            [
                'group_name' => '视频',
                'display_name' => '阿里云视频上传',
                'slug' => 'video.token.aliyun.create',
                'method' => 'POST',
                'url' => 'video/token/aliyun/create',
            ],

            // 友情链接
            [
                'group_name' => '友情链接',
                'display_name' => '友情链接列表',
                'slug' => 'link',
                'method' => 'GET',
                'url' => 'link',
            ],
            [
                'group_name' => '友情链接',
                'display_name' => '友情链接添加',
                'slug' => 'link.store',
                'method' => 'POST',
                'url' => 'link',
            ],
            [
                'group_name' => '友情链接',
                'display_name' => '友情链接查看',
                'slug' => 'link.edit',
                'method' => 'GET',
                'url' => 'link/\d+',
            ],
            [
                'group_name' => '友情链接',
                'display_name' => '友情链接编辑',
                'slug' => 'link.update',
                'method' => 'PUT',
                'url' => 'link/\d+',
            ],
            [
                'group_name' => '友情链接',
                'display_name' => '友情链接删除',
                'slug' => 'link.destroy',
                'method' => 'DELETE',
                'url' => 'link/\d+',
            ],

            // 幻灯片
            [
                'group_name' => '幻灯片',
                'display_name' => '幻灯片列表',
                'slug' => 'slider',
                'method' => 'GET',
                'url' => 'slider',
            ],
            [
                'group_name' => '幻灯片',
                'display_name' => '幻灯片添加',
                'slug' => 'slider.store',
                'method' => 'POST',
                'url' => 'slider',
            ],
            [
                'group_name' => '幻灯片',
                'display_name' => '幻灯片查看',
                'slug' => 'slider.edit',
                'method' => 'GET',
                'url' => 'slider/\d+',
            ],
            [
                'group_name' => '幻灯片',
                'display_name' => '幻灯片编辑',
                'slug' => 'slider.update',
                'method' => 'PUT',
                'url' => 'slider/\d+',
            ],
            [
                'group_name' => '幻灯片',
                'display_name' => '幻灯片删除',
                'slug' => 'slider.destroy',
                'method' => 'DELETE',
                'url' => 'slider/\d+',
            ],

            // 广告推广
            [
                'group_name' => '广告推广',
                'display_name' => '广告推广列表',
                'slug' => 'ad_from',
                'method' => 'GET',
                'url' => 'ad_from',
            ],
            [
                'group_name' => '广告推广',
                'display_name' => '广告推广添加',
                'slug' => 'ad_from.store',
                'method' => 'POST',
                'url' => 'ad_from',
            ],
            [
                'group_name' => '广告推广',
                'display_name' => '广告推广查看',
                'slug' => 'ad_from.edit',
                'method' => 'GET',
                'url' => 'ad_from/\d+',
            ],
            [
                'group_name' => '广告推广',
                'display_name' => '广告推广统计',
                'slug' => 'ad_from.number',
                'method' => 'GET',
                'url' => 'ad_from/\d+/number',
            ],
            [
                'group_name' => '广告推广',
                'display_name' => '广告推广编辑',
                'slug' => 'ad_from.update',
                'method' => 'PUT',
                'url' => 'ad_from/\d+',
            ],
            [
                'group_name' => '广告推广',
                'display_name' => '广告推广删除',
                'slug' => 'ad_from.destroy',
                'method' => 'DELETE',
                'url' => 'ad_from/\d+',
            ],

            // 公告
            [
                'group_name' => '公告',
                'display_name' => '公告列表',
                'slug' => 'announcement',
                'method' => 'GET',
                'url' => 'announcement',
            ],
            [
                'group_name' => '公告',
                'display_name' => '公告添加',
                'slug' => 'announcement.store',
                'method' => 'POST',
                'url' => 'announcement',
            ],
            [
                'group_name' => '公告',
                'display_name' => '公告查看',
                'slug' => 'announcement.edit',
                'method' => 'GET',
                'url' => 'announcement/\d+',
            ],
            [
                'group_name' => '公告',
                'display_name' => '公告编辑',
                'slug' => 'announcement.update',
                'method' => 'PUT',
                'url' => 'announcement/\d+',
            ],
            [
                'group_name' => '公告',
                'display_name' => '公告删除',
                'slug' => 'announcement.destroy',
                'method' => 'DELETE',
                'url' => 'announcement/\d+',
            ],

            // 首页导航
            [
                'group_name' => '首页导航',
                'display_name' => '首页导航列表',
                'slug' => 'nav',
                'method' => 'GET',
                'url' => 'nav',
            ],
            [
                'group_name' => '首页导航',
                'display_name' => '首页导航添加参数',
                'slug' => 'nav.create',
                'method' => 'GET',
                'url' => 'nav/create',
            ],
            [
                'group_name' => '首页导航',
                'display_name' => '首页导航添加',
                'slug' => 'nav.store',
                'method' => 'POST',
                'url' => 'nav',
            ],
            [
                'group_name' => '首页导航',
                'display_name' => '首页导航查看',
                'slug' => 'nav.edit',
                'method' => 'GET',
                'url' => 'nav/\d+',
            ],
            [
                'group_name' => '首页导航',
                'display_name' => '首页导航编辑',
                'slug' => 'nav.update',
                'method' => 'PUT',
                'url' => 'nav/\d+',
            ],
            [
                'group_name' => '首页导航',
                'display_name' => '首页导航删除',
                'slug' => 'nav.destroy',
                'method' => 'DELETE',
                'url' => 'nav/\d+',
            ],

            // 课程评论
            [
                'group_name' => '评论',
                'display_name' => '课程评论列表',
                'slug' => 'course_comment',
                'method' => 'GET',
                'url' => 'course_comment',
            ],
            [
                'group_name' => '评论',
                'display_name' => '课程评论删除',
                'slug' => 'course_comment.destroy',
                'method' => 'POST',
                'url' => 'course_comment/delete',
            ],

            // 视频评论
            [
                'group_name' => '评论',
                'display_name' => '视频评论列表',
                'slug' => 'video_comment',
                'method' => 'GET',
                'url' => 'video_comment',
            ],
            [
                'group_name' => '评论',
                'display_name' => '视频评论删除',
                'slug' => 'video_comment.destroy',
                'method' => 'POST',
                'url' => 'video_comment/delete',
            ],

            // 会员
            [
                'group_name' => 'VIP会员',
                'display_name' => '会员列表',
                'slug' => 'role',
                'method' => 'GET',
                'url' => 'role',
            ],
            [
                'group_name' => 'VIP会员',
                'display_name' => '会员添加',
                'slug' => 'role.store',
                'method' => 'POST',
                'url' => 'role',
            ],
            [
                'group_name' => 'VIP会员',
                'display_name' => '会员查看',
                'slug' => 'role.edit',
                'method' => 'GET',
                'url' => 'role/\d+',
            ],
            [
                'group_name' => 'VIP会员',
                'display_name' => '会员编辑',
                'slug' => 'role.update',
                'method' => 'PUT',
                'url' => 'role/\d+',
            ],
            [
                'group_name' => 'VIP会员',
                'display_name' => '会员删除',
                'slug' => 'role.destroy',
                'method' => 'DELETE',
                'url' => 'role/\d+',
            ],

            // 管理员
            [
                'group_name' => '管理员',
                'display_name' => '管理员列表',
                'slug' => 'administrator',
                'method' => 'GET',
                'url' => 'administrator',
            ],
            [
                'group_name' => '管理员',
                'display_name' => '管理员添加参数',
                'slug' => 'administrator.create',
                'method' => 'GET',
                'url' => 'administrator/create',
            ],
            [
                'group_name' => '管理员',
                'display_name' => '管理员添加',
                'slug' => 'administrator.store',
                'method' => 'POST',
                'url' => 'administrator',
            ],
            [
                'group_name' => '管理员',
                'display_name' => '管理员查看',
                'slug' => 'administrator.edit',
                'method' => 'GET',
                'url' => 'administrator/\d+',
            ],
            [
                'group_name' => '管理员',
                'display_name' => '管理员编辑',
                'slug' => 'administrator.update',
                'method' => 'PUT',
                'url' => 'administrator/\d+',
            ],
            [
                'group_name' => '管理员',
                'display_name' => '管理员删除',
                'slug' => 'administrator.destroy',
                'method' => 'DELETE',
                'url' => 'administrator/\d+',
            ],
            [
                'group_name' => '管理员',
                'display_name' => '管理员修改密码',
                'slug' => 'administrator.password',
                'method' => 'PUT',
                'url' => 'administrator/password',
            ],

            // 管理员角色
            [
                'group_name' => '管理员角色',
                'display_name' => '管理员角色列表',
                'slug' => 'administrator_role',
                'method' => 'GET',
                'url' => 'administrator_role',
            ],
            [
                'group_name' => '管理员角色',
                'display_name' => '管理员角色添加参数',
                'slug' => 'administrator_role.create',
                'method' => 'GET',
                'url' => 'administrator_role/create',
            ],
            [
                'group_name' => '管理员角色',
                'display_name' => '管理员角色添加',
                'slug' => 'administrator_role.store',
                'method' => 'POST',
                'url' => 'administrator_role',
            ],
            [
                'group_name' => '管理员角色',
                'display_name' => '管理员角色查看',
                'slug' => 'administrator_role.edit',
                'method' => 'GET',
                'url' => 'administrator_role/\d+',
            ],
            [
                'group_name' => '管理员角色',
                'display_name' => '管理员角色编辑',
                'slug' => 'administrator_role.update',
                'method' => 'PUT',
                'url' => 'administrator_role/\d+',
            ],
            [
                'group_name' => '管理员角色',
                'display_name' => '管理员角色删除',
                'slug' => 'administrator_role.destroy',
                'method' => 'DELETE',
                'url' => 'administrator_role/\d+',
            ],

            // 课程章节
            [
                'group_name' => '课程',
                'display_name' => '课程章节列表',
                'slug' => 'course_chapter',
                'method' => 'GET',
                'url' => 'course_chapter/\d+',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程章节添加',
                'slug' => 'course_chapter.store',
                'method' => 'POST',
                'url' => 'course_chapter/\d+',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程章节查看',
                'slug' => 'course_chapter.edit',
                'method' => 'GET',
                'url' => 'course_chapter/\d+/\d+',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程章节编辑',
                'slug' => 'course_chapter.update',
                'method' => 'PUT',
                'url' => 'course_chapter/\d+/\d+',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程章节删除',
                'slug' => 'course_chapter.destroy',
                'method' => 'DELETE',
                'url' => 'course_chapter/\d+/\d+',
            ],

            // 课程
            [
                'group_name' => '课程',
                'display_name' => '课程列表',
                'slug' => 'course',
                'method' => 'GET',
                'url' => 'course',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程添加参数',
                'slug' => 'course.create',
                'method' => 'GET',
                'url' => 'course/create',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程添加',
                'slug' => 'course.store',
                'method' => 'POST',
                'url' => 'course',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程查看',
                'slug' => 'course.edit',
                'method' => 'GET',
                'url' => 'course/\d+',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程编辑',
                'slug' => 'course.update',
                'method' => 'PUT',
                'url' => 'course/\d+',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程删除',
                'slug' => 'course.destroy',
                'method' => 'DELETE',
                'url' => 'course/\d+',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程观看记录',
                'slug' => 'course.watchRecords',
                'method' => 'GET',
                'url' => 'course/\d+/watch/records',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程订阅',
                'slug' => 'course.subscribes',
                'method' => 'GET',
                'url' => 'course/\d+/subscribes',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程订阅删除',
                'slug' => 'course.subscribe.delete',
                'method' => 'GET',
                'url' => 'course/\d+/subscribe/delete',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程订阅新增',
                'slug' => 'course.subscribe.create',
                'method' => 'POST',
                'url' => 'course/\d+/subscribe/create',
            ],

            // 视频
            [
                'group_name' => '视频',
                'display_name' => '视频列表',
                'slug' => 'video',
                'method' => 'GET',
                'url' => 'video',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频添加参数',
                'slug' => 'video.create',
                'method' => 'GET',
                'url' => 'video/create',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频添加',
                'slug' => 'video.store',
                'method' => 'POST',
                'url' => 'video',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频查看',
                'slug' => 'video.edit',
                'method' => 'GET',
                'url' => 'video/\d+',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频编辑',
                'slug' => 'video.update',
                'method' => 'PUT',
                'url' => 'video/\d+',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频删除',
                'slug' => 'video.destroy',
                'method' => 'DELETE',
                'url' => 'video/\d+',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频批量删除',
                'slug' => 'video.destroy.multi',
                'method' => 'POST',
                'url' => 'video/delete/multi',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频订阅列表',
                'slug' => 'video.subscribes',
                'method' => 'GET',
                'url' => 'video/\d+/subscribes',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频订阅添加',
                'slug' => 'video.subscribe.create',
                'method' => 'POST',
                'url' => 'video/\d+/subscribe/create',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频订阅删除',
                'slug' => 'video.subscribe.delete',
                'method' => 'GET',
                'url' => 'video/\d+/subscribe/delete',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频观看记录',
                'slug' => 'video.watch.records',
                'method' => 'GET',
                'url' => 'video/\d+/watch/records',
            ],
            [
                'group_name' => '视频',
                'display_name' => '视频批量导入',
                'slug' => 'video.import',
                'method' => 'POST',
                'url' => 'video/import',
            ],

            // 用户
            [
                'group_name' => '用户',
                'display_name' => '用户列表',
                'slug' => 'member',
                'method' => 'GET',
                'url' => 'member',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户添加参数',
                'slug' => 'member.create',
                'method' => 'GET',
                'url' => 'member/create',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户添加',
                'slug' => 'member.store',
                'method' => 'POST',
                'url' => 'member',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户查看',
                'slug' => 'member.edit',
                'method' => 'GET',
                'url' => 'member/\d+',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户编辑',
                'slug' => 'member.update',
                'method' => 'PUT',
                'url' => 'member/\d+',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户详情',
                'slug' => 'member.detail',
                'method' => 'GET',
                'url' => 'member/\d+/detail',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户订阅课程',
                'slug' => 'member.detail.userCourses',
                'method' => 'GET',
                'url' => 'member/\d+/detail/userCourses',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户订阅视频',
                'slug' => 'member.detail.userVideos',
                'method' => 'GET',
                'url' => 'member/\d+/detail/userVideos',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户会员记录',
                'slug' => 'member.detail.userRoles',
                'method' => 'GET',
                'url' => 'member/\d+/detail/userRoles',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户课程收藏',
                'slug' => 'member.detail.userCollect',
                'method' => 'GET',
                'url' => 'member/\d+/detail/userCollect',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户观看历史',
                'slug' => 'member.detail.userHistory',
                'method' => 'GET',
                'url' => 'member/\d+/detail/userHistory',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户订单',
                'slug' => 'member.detail.userOrders',
                'method' => 'GET',
                'url' => 'member/\d+/detail/userOrders',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户邀请记录',
                'slug' => 'member.detail.userInvite',
                'method' => 'GET',
                'url' => 'member/\d+/detail/userInvite',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户积分明细',
                'slug' => 'member.detail.credit1Records',
                'method' => 'GET',
                'url' => 'member/\d+/detail/credit1Records',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户邀请余额提现记录列表',
                'slug' => 'member.inviteBalance.withdrawOrders',
                'method' => 'GET',
                'url' => 'member/inviteBalance/withdrawOrders',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户邀请余额提现处理',
                'slug' => 'member.inviteBalance.withdrawOrders',
                'method' => 'POST',
                'url' => 'member/inviteBalance/withdrawOrders',
            ],
            [
                'group_name' => '用户',
                'display_name' => '积分变动',
                'slug' => 'member.credit1.change',
                'method' => 'POST',
                'url' => 'member/credit1/change',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户标签',
                'slug' => 'member.tags',
                'method' => 'PUT',
                'url' => 'member/\d+/tags',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户备注',
                'slug' => 'member.remark',
                'method' => 'GET',
                'url' => 'member/\d+/remark',
            ],
            [
                'group_name' => '用户',
                'display_name' => '用户备注更新',
                'slug' => 'member.remark.update',
                'method' => 'PUT',
                'url' => 'member/\d+/remark',
            ],

            // 系统配置
            [
                'group_name' => '系统',
                'display_name' => '系统配置读取',
                'slug' => 'setting',
                'method' => 'GET',
                'url' => 'setting',
            ],
            [
                'group_name' => '系统',
                'display_name' => '系统配置保存',
                'slug' => 'setting.save',
                'method' => 'POST',
                'url' => 'setting',
            ],

            // 订单
            [
                'group_name' => '订单',
                'display_name' => '订单列表',
                'slug' => 'order',
                'method' => 'GET',
                'url' => 'order',
            ],
            [
                'group_name' => '订单',
                'display_name' => '订单详情',
                'slug' => 'order.detail',
                'method' => 'GET',
                'url' => 'order/\d+',
            ],
            [
                'group_name' => '订单',
                'display_name' => '订单完成',
                'slug' => 'order.finish',
                'method' => 'GET',
                'url' => 'order/\d+/finish',
            ],

            // 优惠码
            [
                'group_name' => '优惠码',
                'display_name' => '优惠码列表',
                'slug' => 'promoCode',
                'method' => 'GET',
                'url' => 'promoCode',
            ],
            [
                'group_name' => '优惠码',
                'display_name' => '优惠码添加',
                'slug' => 'promoCode.store',
                'method' => 'POST',
                'url' => 'promoCode',
            ],
            [
                'group_name' => '优惠码',
                'display_name' => '优惠码查看',
                'slug' => 'promoCode.edit',
                'method' => 'GET',
                'url' => 'promoCode/\d+',
            ],
            [
                'group_name' => '优惠码',
                'display_name' => '优惠码编辑',
                'slug' => 'promoCode.update',
                'method' => 'PUT',
                'url' => 'promoCode/\d+',
            ],
            [
                'group_name' => '优惠码',
                'display_name' => '优惠码删除',
                'slug' => 'promoCode.destroy.multi',
                'method' => 'POST',
                'url' => 'promoCode/delete/multi',
            ],
            [
                'group_name' => '优惠码',
                'display_name' => '优惠码导入',
                'slug' => 'promoCode.import',
                'method' => 'POST',
                'url' => 'promoCode/import',
            ],
            [
                'group_name' => '优惠码',
                'display_name' => '优惠码批量生成',
                'slug' => 'promoCode.generator',
                'method' => 'POST',
                'url' => 'promoCode/generator',
            ],

            // 课程分类
            [
                'group_name' => '课程',
                'display_name' => '课程分类列表',
                'slug' => 'courseCategory',
                'method' => 'GET',
                'url' => 'courseCategory',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程分类添加',
                'slug' => 'courseCategory.store',
                'method' => 'POST',
                'url' => 'courseCategory',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程分类查看',
                'slug' => 'courseCategory.edit',
                'method' => 'GET',
                'url' => 'courseCategory/\d+',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程分类编辑',
                'slug' => 'courseCategory.update',
                'method' => 'PUT',
                'url' => 'courseCategory/\d+',
            ],
            [
                'group_name' => '课程',
                'display_name' => '课程分类删除',
                'slug' => 'courseCategory.destroy',
                'method' => 'DELETE',
                'url' => 'courseCategory/\d+',
            ],

            // 首页推荐
            [
                'group_name' => '首页推荐',
                'display_name' => '首页推荐列表',
                'slug' => 'indexBanner',
                'method' => 'GET',
                'url' => 'indexBanner',
            ],
            [
                'group_name' => '首页推荐',
                'display_name' => '首页推荐添加参数',
                'slug' => 'indexBanner.create',
                'method' => 'GET',
                'url' => 'indexBanner/create',
            ],
            [
                'group_name' => '首页推荐',
                'display_name' => '首页推荐添加',
                'slug' => 'indexBanner.store',
                'method' => 'POST',
                'url' => 'indexBanner',
            ],
            [
                'group_name' => '首页推荐',
                'display_name' => '首页推荐查看',
                'slug' => 'indexBanner.edit',
                'method' => 'GET',
                'url' => 'indexBanner/\d+',
            ],
            [
                'group_name' => '首页推荐',
                'display_name' => '首页推荐编辑',
                'slug' => 'indexBanner.update',
                'method' => 'PUT',
                'url' => 'indexBanner/\d+',
            ],
            [
                'group_name' => '首页推荐',
                'display_name' => '首页推荐删除',
                'slug' => 'indexBanner.destroy',
                'method' => 'DELETE',
                'url' => 'indexBanner/\d+',
            ],

            // 统计
            [
                'group_name' => '统计',
                'display_name' => '每日注册数量统计',
                'slug' => 'statistic.userRegister',
                'method' => 'GET',
                'url' => 'statistic/userRegister',
            ],
            [
                'group_name' => '统计',
                'display_name' => '每日订单创建数量统计',
                'slug' => 'statistic.orderCreated',
                'method' => 'GET',
                'url' => 'statistic/orderCreated',
            ],
            [
                'group_name' => '统计',
                'display_name' => '每日订单支付数量统计',
                'slug' => 'statistic.orderPaidCount',
                'method' => 'GET',
                'url' => 'statistic/orderPaidCount',
            ],
            [
                'group_name' => '统计',
                'display_name' => '每日订单已支付总额统计',
                'slug' => 'statistic.orderPaidSum',
                'method' => 'GET',
                'url' => 'statistic/orderPaidSum',
            ],
            [
                'group_name' => '统计',
                'display_name' => '课程每日销售数量统计',
                'slug' => 'statistic.courseSell',
                'method' => 'GET',
                'url' => 'statistic/courseSell',
            ],
            [
                'group_name' => '统计',
                'display_name' => '会员每日销售数量统计',
                'slug' => 'statistic.roleSell',
                'method' => 'GET',
                'url' => 'statistic/roleSell',
            ],
            [
                'group_name' => '统计',
                'display_name' => '每日视频观看时长统计',
                'slug' => 'statistic.videoWatchDuration',
                'method' => 'GET',
                'url' => 'statistic/videoWatchDuration',
            ],
            [
                'group_name' => '统计',
                'display_name' => '每日课程观看时长统计',
                'slug' => 'statistic.courseWatchDuration',
                'method' => 'GET',
                'url' => 'statistic/courseWatchDuration',
            ],

            // 课程附件
            [
                'group_name' => '课程附件',
                'display_name' => '课程附件列表',
                'slug' => 'course_attach',
                'method' => 'GET',
                'url' => 'course_attach',
            ],
            [
                'group_name' => '课程附件',
                'display_name' => '课程附件创建',
                'slug' => 'course_attach.store',
                'method' => 'POST',
                'url' => 'course_attach',
            ],
            [
                'group_name' => '课程附件',
                'display_name' => '课程附件删除',
                'slug' => 'course_attach.destroy',
                'method' => 'DELETE',
                'url' => 'course_attach/\d+',
            ],

            // 微信公众号消息回复
            [
                'group_name' => '微信公众号消息回复',
                'display_name' => '微信公众号消息回复列表',
                'slug' => 'mpWechatMessageReply',
                'method' => 'GET',
                'url' => 'mpWechatMessageReply',
            ],
            [
                'group_name' => '微信公众号消息回复',
                'display_name' => '微信公众号消息创建',
                'slug' => 'mpWechatMessageReply.create',
                'method' => 'GET',
                'url' => 'mpWechatMessageReply/create',
            ],
            [
                'group_name' => '微信公众号消息回复',
                'display_name' => '微信公众号消息回复添加',
                'slug' => 'mpWechatMessageReply.store',
                'method' => 'POST',
                'url' => 'mpWechatMessageReply',
            ],
            [
                'group_name' => '微信公众号消息回复',
                'display_name' => '微信公众号消息回复查看',
                'slug' => 'mpWechatMessageReply.edit',
                'method' => 'GET',
                'url' => 'mpWechatMessageReply/\d+',
            ],
            [
                'group_name' => '微信公众号消息回复',
                'display_name' => '微信公众号消息回复编辑',
                'slug' => 'mpWechatMessageReply.update',
                'method' => 'PUT',
                'url' => 'mpWechatMessageReply/\d+',
            ],
            [
                'group_name' => '微信公众号消息回复',
                'display_name' => '微信公众号消息回复删除',
                'slug' => 'mpWechatMessageReply.destroy',
                'method' => 'DELETE',
                'url' => 'mpWechatMessageReply/\d+',
            ],

            // 微信公众号操作
            [
                'group_name' => '微信公众号菜单',
                'display_name' => '微信公众号菜单查询',
                'slug' => 'mpWechat.menu',
                'method' => 'GET',
                'url' => 'mpWechat/menu',
            ],
            [
                'group_name' => '微信公众号菜单',
                'display_name' => '微信公众号菜单更新',
                'slug' => 'mpWechat.menu.update',
                'method' => 'PUT',
                'url' => 'mpWechat/menu',
            ],
            [
                'group_name' => '微信公众号菜单',
                'display_name' => '微信公众号菜单清空',
                'slug' => 'mpWechat.menu.empty',
                'method' => 'DELETE',
                'url' => 'mpWechat/menu',
            ],
        ];

        foreach ($permissions as $permission) {
            $exists = \App\Models\AdministratorPermission::where('slug', $permission['slug'])
                ->where('method', $permission['method'])
                ->exists();
            if ($exists) {
                continue;
            }
            \App\Models\AdministratorPermission::create([
                'display_name' => $permission['display_name'],
                'group_name' => $permission['group_name'],
                'slug' => $permission['slug'],
                'description' => $permission['description'] ?? '',
                'method' => $permission['method'],
                'url' => $permission['url'],
                'route' => $permission['route'] ?? '',
            ]);
        }
    }
}
