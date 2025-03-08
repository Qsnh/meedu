<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Constant\BackendApiConstant;

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
            // 主面板
            [
                'group_name' => '主面板',
                'children' => [
                    [
                        'display_name' => '主面板',
                        'slug' => 'dashboard',
                        'method' => 'GET',
                        'url' => '(^dashboard$|^dashboard\/check$|^dashboard\/system\/info$|^dashboard\/graph$)',
                    ],
                ],
            ],
            // 录播课
            [
                'group_name' => '录播课',
                'children' => [
                    // 课程分类
                    [
                        'display_name' => '录播课-分类-列表',
                        'slug' => 'courseCategory',
                        'method' => 'GET',
                        'url' => 'courseCategory',
                    ],
                    [
                        'display_name' => '录播课-分类-添加',
                        'slug' => 'courseCategory.store',
                        'method' => 'GET|POST',
                        'url' => '(^courseCategory$|^courseCategory\/create$)',
                    ],
                    [
                        'display_name' => '录播课-分类-编辑',
                        'slug' => 'courseCategory.update',
                        'method' => 'GET|PUT',
                        'url' => 'courseCategory/\d+',
                    ],
                    [
                        'display_name' => '录播课-分类-删除',
                        'slug' => 'courseCategory.destroy',
                        'method' => 'DELETE',
                        'url' => 'courseCategory/\d+',
                    ],

                    // 课程
                    [
                        'display_name' => '录播课-列表',
                        'slug' => 'course',
                        'method' => 'GET',
                        'url' => 'course',
                    ],
                    [
                        'display_name' => '录播课-添加',
                        'slug' => 'course.store',
                        'method' => 'GET|POST',
                        'url' => '(^course\/create$|^course$)',
                    ],
                    [
                        'display_name' => '录播课-编辑',
                        'slug' => 'course.update',
                        'method' => 'GET|PUT',
                        'url' => 'course/\d+',
                    ],
                    [
                        'display_name' => '录播课-删除',
                        'slug' => 'course.destroy',
                        'method' => 'DELETE',
                        'url' => 'course/\d+',
                    ],
                    [
                        'display_name' => '录播课-学员观看记录-列表',
                        'slug' => 'course.watchRecords',
                        'method' => 'GET',
                        'url' => '(^course\/\d+\/watch\/records$|^course\/\d+\/user\/\d+\/watch\/records$)',
                    ],
                    [
                        'display_name' => '录播课-学员观看记录-删除',
                        'slug' => 'course.watchRecords.delete',
                        'method' => 'POST',
                        'url' => 'course/\d+/watch/records/delete',
                    ],
                    [
                        'display_name' => '录播课-付费学员-列表',
                        'slug' => 'course.subscribes',
                        'method' => 'GET',
                        'url' => 'course/\d+/subscribes',
                    ],
                    [
                        'display_name' => '录播课-付费学员-新增',
                        'slug' => 'course.subscribe.create',
                        'method' => 'POST',
                        'url' => '(^course\/\d+\/subscribe\/create|^course\/\d+\/subscribe\/import$)',
                    ],
                    [
                        'display_name' => '录播课-付费学员-删除',
                        'slug' => 'course.subscribe.delete',
                        'method' => 'GET',
                        'url' => 'course/\d+/subscribe/delete',
                    ],

                    // 课程章节
                    [
                        'display_name' => '录播课-章节-列表',
                        'slug' => 'course_chapter',
                        'method' => 'GET',
                        'url' => 'course_chapter/\d+',
                    ],
                    [
                        'display_name' => '录播课-章节-添加',
                        'slug' => 'course_chapter.store',
                        'method' => 'POST',
                        'url' => 'course_chapter/\d+',
                    ],
                    [
                        'display_name' => '录播课-章节-编辑',
                        'slug' => 'course_chapter.update',
                        'method' => 'GET|PUT',
                        'url' => 'course_chapter/\d+/\d+',
                    ],
                    [
                        'display_name' => '录播课-章节-删除',
                        'slug' => 'course_chapter.destroy',
                        'method' => 'DELETE',
                        'url' => 'course_chapter/\d+/\d+',
                    ],

                    // 录播课评论
                    [
                        'display_name' => '录播课-评论-列表',
                        'slug' => 'course_comment',
                        'method' => 'GET',
                        'url' => 'course_comment',
                    ],
                    [
                        'display_name' => '录播课-评论-删除',
                        'slug' => 'course_comment.destroy',
                        'method' => 'POST',
                        'url' => 'course_comment/delete',
                    ],
                    [
                        'display_name' => '录播课-评论-审核',
                        'slug' => 'course_comment.check',
                        'method' => 'POST',
                        'url' => 'course_comment/check',
                    ],

                    // 课时
                    [
                        'display_name' => '录播课-课时-列表',
                        'slug' => 'video',
                        'method' => 'GET',
                        'url' => 'video',
                    ],
                    [
                        'display_name' => '录播课-课时-添加',
                        'slug' => 'video.store',
                        'method' => 'GET|POST',
                        'url' => '(^video$|^video\/create$|^video\/import$)',
                    ],
                    [
                        'display_name' => '录播课-课时-编辑',
                        'slug' => 'video.update',
                        'method' => 'GET|PUT',
                        'url' => 'video/\d+',
                    ],
                    [
                        'display_name' => '录播课-课时-删除',
                        'slug' => 'video.destroy',
                        'method' => 'DELETE|POST',
                        'url' => '(^video\/\d+$|^video\/delete\/multi$)',
                    ],
                    [
                        'display_name' => '录播课-课时-付费学员-列表',
                        'slug' => 'video.subscribes',
                        'method' => 'GET',
                        'url' => 'video/\d+/subscribes',
                    ],
                    [
                        'display_name' => '录播课-课时-付费学员-添加',
                        'slug' => 'video.subscribe.create',
                        'method' => 'POST',
                        'url' => 'video/\d+/subscribe/create',
                    ],
                    [
                        'display_name' => '录播课-课时-付费学员-删除',
                        'slug' => 'video.subscribe.delete',
                        'method' => 'GET',
                        'url' => 'video/\d+/subscribe/delete',
                    ],
                    [
                        'display_name' => '录播课-课时-观看记录-列表',
                        'slug' => 'video.watch.records',
                        'method' => 'GET',
                        'url' => 'video/\d+/watch/records',
                    ],

                    // 课时评论
                    [
                        'display_name' => '录播课-课时-评论-列表',
                        'slug' => 'video_comment',
                        'method' => 'GET',
                        'url' => 'video_comment',
                    ],
                    [
                        'display_name' => '录播课-课时-评论-删除',
                        'slug' => 'video_comment.destroy',
                        'method' => 'POST',
                        'url' => 'video_comment/delete',
                    ],
                    [
                        'display_name' => '录播课-课时-评论-审核',
                        'slug' => 'video_comment.check',
                        'method' => 'POST',
                        'url' => 'video_comment/check',
                    ],

                    // 课程附件
                    [
                        'display_name' => '录播课-附件-列表',
                        'slug' => 'course_attach',
                        'method' => 'GET',
                        'url' => 'course_attach',
                    ],
                    [
                        'display_name' => '录播课-附件-添加',
                        'slug' => 'course_attach.store',
                        'method' => 'POST',
                        'url' => '(^course_attach|^course_attach\/create$)',
                    ],
                    [
                        'display_name' => '录播课-附件-删除',
                        'slug' => 'course_attach.destroy',
                        'method' => 'DELETE',
                        'url' => 'course_attach/\d+',
                    ],
                ],
            ],

            // VIP会员
            [
                'group_name' => 'VIP会员',
                'children' => [
                    [
                        'display_name' => 'VIP会员-列表',
                        'slug' => 'role',
                        'method' => 'GET',
                        'url' => 'role',
                    ],
                    [
                        'display_name' => 'VIP会员-添加',
                        'slug' => 'role.store',
                        'method' => 'GET|POST',
                        'url' => '(^role$|^role\/create$)',
                    ],
                    [
                        'display_name' => 'VIP会员-编辑',
                        'slug' => 'role.update',
                        'method' => 'GET|PUT',
                        'url' => 'role/\d+',
                    ],
                    [
                        'display_name' => 'VIP会员-删除',
                        'slug' => 'role.destroy',
                        'method' => 'DELETE',
                        'url' => 'role/\d+',
                    ],
                ],
            ],

            // 学员
            [
                'group_name' => '学员',
                'children' => [
                    [
                        'display_name' => '学员-列表',
                        'slug' => 'member',
                        'method' => 'GET',
                        'url' => 'member',
                    ],
                    [
                        'display_name' => '学员-添加',
                        'slug' => 'member.store',
                        'method' => 'GET|POST',
                        'url' => '(^member$|^member\/create$|^member\/import$)',
                    ],
                    [
                        'display_name' => '学员-编辑',
                        'slug' => 'member.update',
                        'method' => 'GET|PUT',
                        'url' => '(^member\/\d+$|^member\/field\/multi$)',
                    ],
                    [
                        'display_name' => '学员-详情',
                        'slug' => 'member.detail',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail',
                    ],
                    [
                        'display_name' => '学员-已购-录播课-列表',
                        'slug' => 'member.detail.userCourses',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail/userCourses',
                    ],
                    [
                        'display_name' => '学员-已购-课时-列表',
                        'slug' => 'member.detail.userVideos',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail/userVideos',
                    ],
                    [
                        'display_name' => '学员-已购-VIP会员-列表',
                        'slug' => 'member.detail.userRoles',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail/userRoles',
                    ],
                    [
                        'display_name' => '学员-收藏-录播课-列表',
                        'slug' => 'member.detail.userCollect',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail/userCollect',
                    ],
                    [
                        'display_name' => '学员-学习历史-录播课-列表',
                        'slug' => 'member.detail.userHistory',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail/userHistory',
                    ],
                    [
                        'display_name' => '学员-学习历史-课时-列表',
                        'slug' => 'member.video.watch.records',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail/videoWatchRecords',
                    ],
                    [
                        'display_name' => '学员-订单-列表',
                        'slug' => 'member.detail.userOrders',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail/userOrders',
                    ],
                    [
                        'display_name' => '学员-积分-明细列表',
                        'slug' => 'member.detail.credit1Records',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail/credit1Records',
                    ],
                    [
                        'display_name' => '学员-积分-变动',
                        'slug' => 'member.credit1.change',
                        'method' => 'POST',
                        'url' => 'member/credit1/change',
                    ],
                    [
                        'display_name' => '学员-备注',
                        'slug' => 'member.remark',
                        'method' => 'GET',
                        'url' => 'member/\d+/remark',
                    ],
                    [
                        'display_name' => '学员-备注-编辑',
                        'slug' => 'member.remark.update',
                        'method' => 'PUT',
                        'url' => 'member/\d+/remark',
                    ],
                    [
                        'display_name' => '学员-站内消息-发送',
                        'slug' => 'member.message.send',
                        'method' => 'POST',
                        'url' => '(^member\/\d+\/message$|^member\/message\/multi$)',
                    ],
                    [
                        'display_name' => '学员-删除',
                        'slug' => 'member.destroy',
                        'method' => 'DELETE',
                        'url' => 'member/\d+',
                    ],
                    [
                        'display_name' => '学员-实名信息-删除',
                        'slug' => 'member.profile.destroy',
                        'method' => 'DELETE',
                        'url' => 'member/\d+/profile',
                    ],

                    // 学员标签
                    [
                        'display_name' => '学员-标签-列表',
                        'slug' => 'member.tag',
                        'method' => 'GET',
                        'url' => 'member/tag/index',
                    ],
                    [
                        'display_name' => '学员-标签-添加',
                        'slug' => 'member.tag.store',
                        'method' => 'POST',
                        'url' => 'member/tag/create',
                    ],
                    [
                        'display_name' => '学员-标签-编辑',
                        'slug' => 'member.tag.update',
                        'method' => 'GET|PUT',
                        'url' => 'member/tag/\d+',
                    ],
                    [
                        'display_name' => '学员-标签-删除',
                        'slug' => 'member.tag.destroy',
                        'method' => 'DELETE',
                        'url' => 'member/tag/\d+',
                    ],
                    [
                        'display_name' => '学员-标签-绑定',
                        'slug' => 'member.tags',
                        'method' => 'PUT',
                        'url' => 'member/\d+/tags',
                    ],

                    [
                        'display_name' => '[V2]学员-已购-录播课-列表',
                        'slug' => 'v2.member.courses',
                        'method' => 'GET',
                        'url' => 'member/courses',
                    ],
                    [
                        'display_name' => '[V2]学员-已购-录播课-课时观看明细',
                        'slug' => 'v2.member.course.progress',
                        'method' => 'GET',
                        'url' => 'member/courseProgress',
                    ],
                    [
                        'display_name' => '[V2]学员-已购-课时-列表',
                        'slug' => 'v2.member.videos',
                        'method' => 'GET',
                        'url' => 'member/videos',
                    ],
                ],
            ],

            // 系统
            [
                'group_name' => '系统',
                'children' => [
                    // 系统配置
                    [
                        'display_name' => '系统-配置-查看',
                        'slug' => 'setting',
                        'method' => 'GET',
                        'url' => 'setting',
                    ],
                    [
                        'display_name' => '系统-配置-编辑',
                        'slug' => 'setting.save',
                        'method' => 'POST',
                        'url' => 'setting',
                    ],

                    // 管理员
                    [
                        'display_name' => '系统-管理员-列表',
                        'slug' => 'administrator',
                        'method' => 'GET',
                        'url' => 'administrator',
                    ],
                    [
                        'display_name' => '系统-管理员-添加',
                        'slug' => 'administrator.store',
                        'method' => 'GET|POST',
                        'url' => '(^administrator\/create$|^administrator$)',
                    ],
                    [
                        'display_name' => '系统-管理员-编辑',
                        'slug' => 'administrator.update',
                        'method' => 'GET|PUT',
                        'url' => 'administrator/\d+',
                    ],
                    [
                        'display_name' => '系统-管理员-删除',
                        'slug' => 'administrator.destroy',
                        'method' => 'DELETE',
                        'url' => 'administrator/\d+',
                    ],

                    // 管理员角色
                    [
                        'display_name' => '系统-管理员角色-列表',
                        'slug' => 'administrator_role',
                        'method' => 'GET',
                        'url' => 'administrator_role',
                    ],
                    [
                        'display_name' => '系统-管理员角色-添加',
                        'slug' => 'administrator_role.store',
                        'method' => 'GET|POST',
                        'url' => '(^administrator_role\/create$|^administrator_role$)',
                    ],
                    [
                        'display_name' => '系统-管理员角色-编辑',
                        'slug' => 'administrator_role.update',
                        'method' => 'GET|PUT',
                        'url' => 'administrator_role/\d+',
                    ],
                    [
                        'display_name' => '系统-管理员角色-删除',
                        'slug' => 'administrator_role.destroy',
                        'method' => 'DELETE',
                        'url' => 'administrator_role/\d+',
                    ],

                    // 审计日志
                    [
                        'display_name' => '系统-审计日志-查看',
                        'slug' => 'system.audit.log',
                        'method' => 'GET',
                        'url' => '(^log/admin$|^log/userLogin$|^log/uploadImages$|^log/runtime$)',
                    ],
                    [
                        'display_name' => '系统-审计日志-清空',
                        'slug' => 'system.audit.log.clear',
                        'method' => 'DELETE',
                        'url' => 'log/\s+',
                    ],
                ],
            ],

            // 订单
            [
                'group_name' => '订单',
                'children' => [
                    [
                        'display_name' => '订单-列表',
                        'slug' => 'order',
                        'method' => 'GET',
                        'url' => 'order',
                    ],
                    [
                        'display_name' => '订单-详情',
                        'slug' => 'order.detail',
                        'method' => 'GET',
                        'url' => 'order/\d+',
                    ],
                    [
                        'display_name' => '订单-置为完成',
                        'slug' => 'order.finish',
                        'method' => 'GET',
                        'url' => 'order/\d+/finish',
                    ],
                    [
                        'display_name' => '退款-订单-列表',
                        'slug' => 'order.refund.list',
                        'method' => 'GET',
                        'url' => 'order/refund/list',
                    ],
                    [
                        'display_name' => '订单-退款-添加',
                        'slug' => 'order.refund',
                        'method' => 'POST',
                        'url' => 'order/\d+/refund',
                    ],
                    [
                        'display_name' => '订单-退款-删除',
                        'slug' => 'order.refund.delete',
                        'method' => 'DELETE',
                        'url' => 'order/refund/\d+',
                    ],
                    [
                        'display_name' => '订单-取消订单',
                        'slug' => 'order.cancel',
                        'method' => 'GET',
                        'url' => 'order/\d+/cancel',
                    ],
                ],
            ],

            // 优惠码
            [
                'group_name' => '优惠码',
                'children' => [
                    [
                        'display_name' => '优惠码-列表',
                        'slug' => 'promoCode',
                        'method' => 'GET',
                        'url' => 'promoCode',
                    ],
                    [
                        'display_name' => '优惠码-添加',
                        'slug' => 'promoCode.store',
                        'method' => 'POST',
                        'url' => '(^promoCode$|^promoCode\/import$)',
                    ],
                    [
                        'display_name' => '优惠码-编辑',
                        'slug' => 'promoCode.update',
                        'method' => 'GET|PUT',
                        'url' => 'promoCode/\d+',
                    ],
                    [
                        'display_name' => '优惠码-删除',
                        'slug' => 'promoCode.destroy.multi',
                        'method' => 'POST',
                        'url' => 'promoCode/delete/multi',
                    ],
                    [
                        'display_name' => '优惠码-批量生成',
                        'slug' => 'promoCode.generator',
                        'method' => 'POST',
                        'url' => 'promoCode/generator',
                    ],
                ],
            ],

            // 装修
            [
                'group_name' => '装修',
                'children' => [
                    [
                        'display_name' => '装修-模块-列表',
                        'slug' => 'viewBlock',
                        'method' => 'GET',
                        'url' => 'viewBlock/index',
                    ],
                    [
                        'display_name' => '装修-模块-添加',
                        'slug' => 'viewBlock.store',
                        'method' => 'POST',
                        'url' => 'viewBlock/create',
                    ],
                    [
                        'display_name' => '装修-模块-编辑',
                        'slug' => 'viewBlock.update',
                        'method' => 'GET|PUT',
                        'url' => 'viewBlock/\d+',
                    ],
                    [
                        'display_name' => '装修-模块-删除',
                        'slug' => 'viewBlock.destroy',
                        'method' => 'DELETE',
                        'url' => 'viewBlock/\d+',
                    ],

                    // 幻灯片
                    [
                        'display_name' => '装修-幻灯片-列表',
                        'slug' => 'slider',
                        'method' => 'GET',
                        'url' => 'slider',
                    ],
                    [
                        'display_name' => '装修-幻灯片-添加',
                        'slug' => 'slider.store',
                        'method' => 'POST',
                        'url' => 'slider',
                    ],
                    [
                        'display_name' => '装修-幻灯片-编辑',
                        'slug' => 'slider.update',
                        'method' => 'GET|PUT',
                        'url' => 'slider/\d+',
                    ],
                    [
                        'display_name' => '装修-幻灯片-删除',
                        'slug' => 'slider.destroy',
                        'method' => 'DELETE',
                        'url' => 'slider/\d+',
                    ],

                    // 友情链接
                    [
                        'display_name' => '装修-友情链接-列表',
                        'slug' => 'link',
                        'method' => 'GET',
                        'url' => 'link',
                    ],
                    [
                        'display_name' => '装修-友情链接-添加',
                        'slug' => 'link.store',
                        'method' => 'POST',
                        'url' => 'link',
                    ],
                    [
                        'display_name' => '装修-友情链接-编辑',
                        'slug' => 'link.update',
                        'method' => 'GET|PUT',
                        'url' => 'link/\d+',
                    ],
                    [
                        'display_name' => '装修-友情链接-删除',
                        'slug' => 'link.destroy',
                        'method' => 'DELETE',
                        'url' => 'link/\d+',
                    ],

                    // 公告
                    [
                        'display_name' => '装修-公告-列表',
                        'slug' => 'announcement',
                        'method' => 'GET',
                        'url' => 'announcement',
                    ],
                    [
                        'display_name' => '装修-公告-添加',
                        'slug' => 'announcement.store',
                        'method' => 'POST',
                        'url' => 'announcement',
                    ],
                    [
                        'display_name' => '装修-公告-编辑',
                        'slug' => 'announcement.update',
                        'method' => 'GET|PUT',
                        'url' => 'announcement/\d+',
                    ],
                    [
                        'display_name' => '装修-公告-删除',
                        'slug' => 'announcement.destroy',
                        'method' => 'DELETE',
                        'url' => 'announcement/\d+',
                    ],

                    // PC首页导航
                    [
                        'display_name' => '装修-PC首页导航-列表',
                        'slug' => 'nav',
                        'method' => 'GET',
                        'url' => 'nav',
                    ],
                    [
                        'display_name' => '装修-PC首页导航-添加',
                        'slug' => 'nav.store',
                        'method' => 'GET|POST',
                        'url' => '(^nav\/create$|^nav$)',
                    ],
                    [
                        'display_name' => '装修-PC首页导航-编辑',
                        'slug' => 'nav.update',
                        'method' => 'GET|PUT',
                        'url' => 'nav/\d+',
                    ],
                    [
                        'display_name' => '装修-PC首页导航-删除',
                        'slug' => 'nav.destroy',
                        'method' => 'DELETE',
                        'url' => 'nav/\d+',
                    ],
                ],
            ],

            // 上传视频管理
            [
                'group_name' => '素材库',
                'children' => [
                    [
                        'display_name' => '素材库-视频-列表',
                        'slug' => 'media.video.list',
                        'method' => 'GET',
                        'url' => '(^media/videos/index$|^media/video-category/index$)',
                    ],
                    [
                        'display_name' => '素材库-视频-删除',
                        'slug' => 'media.video.delete.multi',
                        'method' => 'POST',
                        'url' => 'media/videos/delete/multi',
                    ],
                    [
                        'display_name' => '素材库-视频-上传',
                        'slug' => 'media.video.upload',
                        'method' => 'POST',
                        'url' => '(^video\/token\/aliyun\/refresh$|^video\/token\/aliyun\/create$|^video\/token\/tencent$|^media\/videos\/record-category-id$)',
                    ],
                    [
                        'display_name' => '素材库-视频-更换分类',
                        'slug' => 'media.video.change-category',
                        'method' => 'POST',
                        'url' => 'media/videos/change-category',
                    ],
                    [
                        'display_name' => '素材库-图片-删除',
                        'slug' => 'media.image.delete.multi',
                        'method' => 'POST',
                        'url' => 'media/image/delete/multi',
                    ],
                    [
                        'display_name' => '素材库-图片-列表',
                        'slug' => 'media.image.index',
                        'method' => 'GET',
                        'url' => 'media/image/index',
                    ],
                    [
                        'display_name' => '素材库-图片-上传',
                        'slug' => 'media.image.store',
                        'method' => 'POST',
                        'url' => 'media/image/create',
                    ],
                    [
                        'display_name' => '素材库-视频分类-添加',
                        'slug' => 'media.video-category.store',
                        'method' => 'POST',
                        'url' => 'media/video-category/create',
                    ],
                    [
                        'display_name' => '素材库-视频分类-编辑',
                        'slug' => 'media.video-category.update',
                        'method' => 'GET|PUT',
                        'url' => '(^media/video-category/\d+$|^media/video-category/change-sort$|^media/video-category/change-parent$)',
                    ],
                    [
                        'display_name' => '素材库-视频分类-删除',
                        'slug' => 'media.video-category.delete',
                        'method' => 'DELETE',
                        'url' => 'media/video-category/\d+',
                    ],
                ],
            ],

            // 数据统计权限
            [
                'group_name' => '数据',
                'children' => [
                    [
                        'display_name' => '数据-交易数据',
                        'slug' => 'stats.transaction',
                        'method' => 'GET',
                        'url' => '(^stats/transaction$|^stats/transaction-top$|^stats/transaction-graph$)',
                    ],
                    [
                        'display_name' => '数据-商品数据',
                        'slug' => 'stats.course',
                        'method' => 'GET',
                        'url' => '(^stats/transaction-top$)',
                    ],
                    [
                        'display_name' => '数据-学员数据',
                        'slug' => 'stats.user',
                        'method' => 'GET',
                        'url' => '(^stats/user$|^stats/user-top$|^stats/user-paid-top$|^stats/user-graph$)',
                    ],
                ],
            ],

            // 敏感数据权限
            [
                'group_name' => '字段权限',
                'children' => [
                    [
                        'display_name' => '字段权限-学员-手机号',
                        'slug' => BackendApiConstant::P_DATA_USER_MOBILE,
                        'method' => 'DATA',
                        'url' => '',
                    ],
                    [
                        'display_name' => '字段权限-学员-真实姓名',
                        'slug' => BackendApiConstant::P_DATA_USER_REAL_NAME,
                        'method' => 'DATA',
                        'url' => '',
                    ],
                    [
                        'display_name' => '字段权限-学员-身份证号',
                        'slug' => BackendApiConstant::P_DATA_USER_ID_NUMBER,
                        'method' => 'DATA',
                        'url' => '',
                    ],
                    [
                        'display_name' => '字段权限-管理员-邮箱',
                        'slug' => BackendApiConstant::P_DATA_ADMINISTRATOR_EMAIL,
                        'method' => 'DATA',
                        'url' => '',
                    ],
                ],
            ],
        ];

        foreach ($permissions as $groupItem) {
            $groupName = $groupItem['group_name'];
            foreach ($groupItem['children'] as $permissionItem) {
                $permissionData = array_merge($permissionItem, [
                    'group_name' => $groupName,
                    'description' => '',
                    'route' => '',
                ]);

                $permission = \App\Models\AdministratorPermission::query()->where('slug', $permissionData['slug'])->first();

                if ($permission) {
                    $permission->fill($permissionData)->save();
                } else {
                    \App\Models\AdministratorPermission::create($permissionData);
                }
            }
        }
    }
}
