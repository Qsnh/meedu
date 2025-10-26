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
                'sort' => 1000,
                'children' => [
                    [
                        'display_name' => '主面板',
                        'slug' => 'dashboard',
                        'method' => 'GET',
                        'url' => '(^dashboard$|^dashboard\/check$|^dashboard\/system\/info$|^dashboard\/graph$)',
                        'sort' => 1000,
                    ],
                ],
            ],

            // 装修
            [
                'group_name' => '装修',
                'sort' => 2000,
                'children' => [
                    // 装修页面
                    [
                        'display_name' => '装修-页面-列表',
                        'slug' => 'decorationPage',
                        'method' => 'GET',
                        'url' => 'decoration-page',
                        'sort' => 2000,
                    ],
                    [
                        'display_name' => '装修-页面-添加',
                        'slug' => 'decorationPage.store',
                        'method' => 'POST',
                        'url' => 'decoration-page',
                        'sort' => 2001,
                    ],
                    [
                        'display_name' => '装修-页面-编辑',
                        'slug' => 'decorationPage.update',
                        'method' => 'GET|PUT',
                        'url' => 'decoration-page/\d+',
                        'sort' => 2002,
                    ],
                    [
                        'display_name' => '装修-页面-删除',
                        'slug' => 'decorationPage.destroy',
                        'method' => 'DELETE',
                        'url' => 'decoration-page/\d+',
                        'sort' => 2003,
                    ],
                    [
                        'display_name' => '装修-页面-设置默认',
                        'slug' => 'decorationPage.setDefault',
                        'method' => 'POST',
                        'url' => 'decoration-page/\d+/set-default',
                        'sort' => 2004,
                    ],
                    [
                        'display_name' => '装修-页面-复制',
                        'slug' => 'decorationPage.copy',
                        'method' => 'POST',
                        'url' => 'decoration-page/\d+/copy',
                        'sort' => 2005,
                    ],
                    [
                        'display_name' => '装修-页面-装修',
                        'slug' => 'decorationPage.blocks',
                        'method' => 'GET|POST|PUT|DELETE',
                        'url' => '(^viewBlock/index$|^viewBlock/create$|^viewBlock/\d+$)',
                        'sort' => 2006,
                    ],

                    // 友情链接
                    [
                        'display_name' => '装修-友情链接-列表',
                        'slug' => 'link',
                        'method' => 'GET',
                        'url' => 'link/index',
                        'sort' => 2007,
                    ],
                    [
                        'display_name' => '装修-友情链接-添加',
                        'slug' => 'link.store',
                        'method' => 'POST',
                        'url' => 'link/create',
                        'sort' => 2008,
                    ],
                    [
                        'display_name' => '装修-友情链接-编辑',
                        'slug' => 'link.update',
                        'method' => 'GET|PUT',
                        'url' => 'link/\d+',
                        'sort' => 2009,
                    ],
                    [
                        'display_name' => '装修-友情链接-删除',
                        'slug' => 'link.destroy',
                        'method' => 'DELETE',
                        'url' => 'link/\d+',
                        'sort' => 2010,
                    ],

                    // PC首页导航
                    [
                        'display_name' => '装修-PC首页导航-列表',
                        'slug' => 'nav',
                        'method' => 'GET',
                        'url' => 'nav/index',
                        'sort' => 2011,
                    ],
                    [
                        'display_name' => '装修-PC首页导航-添加',
                        'slug' => 'nav.store',
                        'method' => 'GET|POST',
                        'url' => 'nav/create',
                        'sort' => 2012,
                    ],
                    [
                        'display_name' => '装修-PC首页导航-编辑',
                        'slug' => 'nav.update',
                        'method' => 'GET|PUT',
                        'url' => 'nav/\d+',
                        'sort' => 2013,
                    ],
                    [
                        'display_name' => '装修-PC首页导航-删除',
                        'slug' => 'nav.destroy',
                        'method' => 'DELETE',
                        'url' => 'nav/\d+',
                        'sort' => 2014,
                    ],
                ],
            ],

            // 资源
            [
                'group_name' => '资源',
                'sort' => 3000,
                'children' => [
                    // 图片库
                    [
                        'display_name' => '资源-图片库-列表',
                        'slug' => 'media.image.index',
                        'method' => 'GET',
                        'url' => 'media/image/index',
                        'sort' => 3000,
                    ],
                    [
                        'display_name' => '资源-图片库-上传',
                        'slug' => 'media.image.store',
                        'method' => 'POST',
                        'url' => 'media/image/create',
                        'sort' => 3001,
                    ],
                    [
                        'display_name' => '资源-图片库-删除',
                        'slug' => 'media.image.delete.multi',
                        'method' => 'POST',
                        'url' => 'media/image/delete/multi',
                        'sort' => 3002,
                    ],

                    // 视频库
                    [
                        'display_name' => '资源-视频库-列表',
                        'slug' => 'media.video.list',
                        'method' => 'GET',
                        'url' => '(^media/videos/index$|^media/video-category/index$)',
                        'sort' => 3003,
                    ],
                    [
                        'display_name' => '资源-视频库-上传',
                        'slug' => 'media.video.upload',
                        'method' => 'POST',
                        'url' => '(^video\/token\/aliyun\/refresh$|^video\/token\/aliyun\/create$|^video\/token\/tencent$|^media\/videos\/record-category-id$)',
                        'sort' => 3004,
                    ],
                    [
                        'display_name' => '资源-视频库-删除',
                        'slug' => 'media.video.delete.multi',
                        'method' => 'POST',
                        'url' => 'media/videos/delete/multi',
                        'sort' => 3005,
                    ],
                    [
                        'display_name' => '资源-视频库-更换分类',
                        'slug' => 'media.video.change-category',
                        'method' => 'POST',
                        'url' => 'media/videos/change-category',
                        'sort' => 3006,
                    ],

                    // 视频分类
                    [
                        'display_name' => '资源-视频库-视频分类-添加',
                        'slug' => 'media.video-category.store',
                        'method' => 'POST',
                        'url' => 'media/video-category/create',
                        'sort' => 3007,
                    ],
                    [
                        'display_name' => '资源-视频库-视频分类-编辑',
                        'slug' => 'media.video-category.update',
                        'method' => 'GET|PUT',
                        'url' => '(^media/video-category/\d+$|^media/video-category/change-sort$|^media/video-category/change-parent$)',
                        'sort' => 3008,
                    ],
                    [
                        'display_name' => '资源-视频库-视频分类-删除',
                        'slug' => 'media.video-category.delete',
                        'method' => 'DELETE',
                        'url' => 'media/video-category/\d+',
                        'sort' => 3009,
                    ],
                ],
            ],

            // 录播课
            [
                'group_name' => '课程',
                'sort' => 4000,
                'children' => [
                    // 课程分类
                    [
                        'display_name' => '课程-录播课-录播课分类',
                        'slug' => 'courseCategory',
                        'method' => 'GET',
                        'url' => 'courseCategory',
                        'sort' => 4000,
                    ],
                    [
                        'display_name' => '课程-录播课-录播课分类-新建',
                        'slug' => 'courseCategory.store',
                        'method' => 'GET|POST',
                        'url' => '(^courseCategory$|^courseCategory\/create$)',
                        'sort' => 4001,
                    ],
                    [
                        'display_name' => '课程-录播课-录播课分类-编辑',
                        'slug' => 'courseCategory.update',
                        'method' => 'GET|PUT',
                        'url' => 'courseCategory/\d+',
                        'sort' => 4002,
                    ],
                    [
                        'display_name' => '课程-录播课-录播课分类-删除',
                        'slug' => 'courseCategory.destroy',
                        'method' => 'DELETE',
                        'url' => 'courseCategory/\d+',
                        'sort' => 4003,
                    ],

                    // 课程
                    [
                        'display_name' => '课程-录播课',
                        'slug' => 'course',
                        'method' => 'GET',
                        'url' => 'course/index',
                        'sort' => 4004,
                    ],
                    [
                        'display_name' => '课程-录播课-新建',
                        'slug' => 'course.store',
                        'method' => 'GET|POST',
                        'url' => 'course/create',
                        'sort' => 4005,
                    ],
                    [
                        'display_name' => '课程-录播课-编辑',
                        'slug' => 'course.update',
                        'method' => 'GET|PUT',
                        'url' => 'course/\d+',
                        'sort' => 4006,
                    ],
                    [
                        'display_name' => '课程-录播课-删除',
                        'slug' => 'course.destroy',
                        'method' => 'DELETE',
                        'url' => 'course/\d+',
                        'sort' => 4007,
                    ],

                    // 课程-录播课-学员-学习记录
                    [
                        'display_name' => '课程-录播课-学员-学习记录',
                        'slug' => 'course.watchRecords',
                        'method' => 'GET',
                        'url' => '(^course\/\d+\/watch\/records$|^course\/\d+\/user\/\d+\/watch\/records$)',
                        'sort' => 4008,
                    ],
                    [
                        'display_name' => '课程-录播课-学员-学习记录-删除',
                        'slug' => 'course.watchRecords.delete',
                        'method' => 'POST',
                        'url' => 'course/\d+/watch/records/delete',
                        'sort' => 4009,
                    ],

                    // 课程-录播课-学员-付费学员
                    [
                        'display_name' => '课程-录播课-学员-付费学员',
                        'slug' => 'course.subscribes',
                        'method' => 'GET',
                        'url' => 'course/\d+/subscribes',
                        'sort' => 4010,
                    ],
                    [
                        'display_name' => '课程-录播课-学员-付费学员-添加|批量导入',
                        'slug' => 'course.subscribe.create',
                        'method' => 'POST',
                        'url' => '(^course\/\d+\/subscribe\/create|^course\/\d+\/subscribe\/import$)',
                        'sort' => 4011,
                    ],
                    [
                        'display_name' => '课程-录播课-学员-付费学员-删除',
                        'slug' => 'course.subscribe.delete',
                        'method' => 'GET',
                        'url' => 'course/\d+/subscribe/delete',
                        'sort' => 4012,
                    ],

                    // 课程章节
                    [
                        'display_name' => '课程-录播课-课时-章节管理',
                        'slug' => 'course_chapter',
                        'method' => 'GET',
                        'url' => 'course_chapter/\d+/index',
                        'sort' => 4013,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-章节管理-新建',
                        'slug' => 'course_chapter.store',
                        'method' => 'POST',
                        'url' => 'course_chapter/\d+/create',
                        'sort' => 4014,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-章节管理-编辑',
                        'slug' => 'course_chapter.update',
                        'method' => 'GET|PUT',
                        'url' => 'course_chapter/\d+/\d+',
                        'sort' => 4015,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-章节管理-删除',
                        'slug' => 'course_chapter.destroy',
                        'method' => 'DELETE',
                        'url' => 'course_chapter/\d+/\d+',
                        'sort' => 4016,
                    ],

                    // 课时
                    [
                        'display_name' => '课程-录播课-课时',
                        'slug' => 'video',
                        'method' => 'GET',
                        'url' => 'video/index',
                        'sort' => 4017,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-新建|批量导入',
                        'slug' => 'video.store',
                        'method' => 'GET|POST',
                        'url' => '(^video\/create$|^video\/import$)',
                        'sort' => 4018,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-编辑',
                        'slug' => 'video.update',
                        'method' => 'GET|PUT',
                        'url' => 'video/\d+',
                        'sort' => 4019,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-删除',
                        'slug' => 'video.destroy',
                        'method' => 'DELETE|POST',
                        'url' => '(^video\/\d+$|^video\/delete\/multi$)',
                        'sort' => 4020,
                    ],

                    // 课程-录播课-课时-学员
                    [
                        'display_name' => '课程-录播课-课时-学员',
                        'slug' => 'video.watch.records',
                        'method' => 'GET',
                        'url' => 'video/\d+/watch/records',
                        'sort' => 4021,
                    ],

                    // 课程附件
                    [
                        'display_name' => '课程-录播课-附件',
                        'slug' => 'course_attach',
                        'method' => 'GET',
                        'url' => 'course_attach/index',
                        'sort' => 4022,
                    ],
                    [
                        'display_name' => '课程-录播课-附件-新建',
                        'slug' => 'course_attach.store',
                        'method' => 'GET|POST',
                        'url' => 'course_attach/create',
                        'sort' => 4023,
                    ],
                    [
                        'display_name' => '课程-录播课-附件-删除',
                        'slug' => 'course_attach.destroy',
                        'method' => 'DELETE',
                        'url' => 'course_attach/\d+',
                        'sort' => 4024,
                    ],
                ],
            ],

            // 学员
            [
                'group_name' => '学员',
                'sort' => 5000,
                'children' => [
                    [
                        'display_name' => '学员-学员列表',
                        'slug' => 'member',
                        'method' => 'GET',
                        'url' => 'member/index',
                        'sort' => 5000,
                    ],
                    [
                        'display_name' => '学员-学员列表-新建学员|批量导入',
                        'slug' => 'member.store',
                        'method' => 'GET|POST',
                        'url' => '(^member\/create$|^member\/import$)',
                        'sort' => 5001,
                    ],
                    [
                        'display_name' => '学员-学员列表-编辑资料|批量设置|冻结/解冻账号',
                        'slug' => 'member.update',
                        'method' => 'GET|PUT',
                        'url' => '(^member\/\d+$|^member\/field\/multi$)',
                        'sort' => 5002,
                    ],
                    [
                        'display_name' => '学员-学员列表-删除账号',
                        'slug' => 'member.destroy',
                        'method' => 'DELETE',
                        'url' => 'member/\d+',
                        'sort' => 5003,
                    ],
                    [
                        'display_name' => '学员-学员列表-编辑资料',
                        'slug' => 'member.remark.update',
                        'method' => 'PUT',
                        'url' => 'member/\d+/remark',
                        'sort' => 5004,
                    ],
                    [
                        'display_name' => '学员-学员列表-站内消息|批量发消息',
                        'slug' => 'member.message.send',
                        'method' => 'POST',
                        'url' => '(^member\/\d+\/message$|^member\/message\/multi$)',
                        'sort' => 5005,
                    ],

                    // 学员-学员列表-详情
                    [
                        'display_name' => '学员-学员列表-详情',
                        'slug' => 'member.detail',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail',
                        'sort' => 5006,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-变动积分',
                        'slug' => 'member.credit1.change',
                        'method' => 'POST',
                        'url' => 'member/credit1/change',
                        'sort' => 5007,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-修改备注',
                        'slug' => 'member.remark',
                        'method' => 'GET',
                        'url' => 'member/\d+/remark',
                        'sort' => 5008,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-实名信息-重置实名信息',
                        'slug' => 'member.profile.destroy',
                        'method' => 'DELETE',
                        'url' => 'member/\d+/profile',
                        'sort' => 5009,
                    ],

                    // 学员-学员列表-详情-修改标签
                    [
                        'display_name' => '学员-学员列表-详情-修改标签',
                        'slug' => 'member.tags',
                        'method' => 'PUT',
                        'url' => 'member/\d+/tags',
                        'sort' => 5010,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-修改标签-标签管理',
                        'slug' => 'member.tag',
                        'method' => 'GET',
                        'url' => 'member/tag/index',
                        'sort' => 5011,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-修改标签-标签管理-新建',
                        'slug' => 'member.tag.store',
                        'method' => 'POST',
                        'url' => 'member/tag/create',
                        'sort' => 5012,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-修改标签-标签管理-编辑',
                        'slug' => 'member.tag.update',
                        'method' => 'GET|PUT',
                        'url' => 'member/tag/\d+',
                        'sort' => 5013,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-修改标签-标签管理-删除',
                        'slug' => 'member.tag.destroy',
                        'method' => 'DELETE',
                        'url' => 'member/tag/\d+',
                        'sort' => 5014,
                    ],

                    [
                        'display_name' => '学员-学员列表-详情-订单明细',
                        'slug' => 'member.detail.userOrders',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail/userOrders',
                        'sort' => 5015,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-积分明细',
                        'slug' => 'member.detail.credit1Records',
                        'method' => 'GET',
                        'url' => 'member/\d+/detail/credit1Records',
                        'sort' => 5016,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-录播课学习',
                        'slug' => 'v2.member.courses',
                        'method' => 'GET',
                        'url' => 'member/courses',
                        'sort' => 5017,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-录播课学习-学习进度',
                        'slug' => 'v2.member.course.progress',
                        'method' => 'GET',
                        'url' => 'member/courseProgress',
                        'sort' => 5018,
                    ],
                ],
            ],

            // 财务
            [
                'group_name' => '财务',
                'sort' => 6000,
                'children' => [
                    [
                        'display_name' => '财务-全部订单-列表',
                        'slug' => 'order',
                        'method' => 'GET',
                        'url' => 'order',
                        'sort' => 6000,
                    ],
                    [
                        'display_name' => '财务-全部订单-详情',
                        'slug' => 'order.detail',
                        'method' => 'GET',
                        'url' => 'order/\d+',
                        'sort' => 6001,
                    ],
                    [
                        'display_name' => '财务-全部订单-置为完成',
                        'slug' => 'order.finish',
                        'method' => 'GET',
                        'url' => 'order/\d+/finish',
                        'sort' => 6002,
                    ],
                    [
                        'display_name' => '财务-全部订单-取消订单',
                        'slug' => 'order.cancel',
                        'method' => 'GET',
                        'url' => 'order/\d+/cancel',
                        'sort' => 6003,
                    ],
                    [
                        'display_name' => '财务-全部订单-退款-列表',
                        'slug' => 'order.refund.list',
                        'method' => 'GET',
                        'url' => 'order/refund/list',
                        'sort' => 6004,
                    ],
                    [
                        'display_name' => '财务-全部订单-退款-添加',
                        'slug' => 'order.refund',
                        'method' => 'POST',
                        'url' => 'order/\d+/refund',
                        'sort' => 6005,
                    ],
                    [
                        'display_name' => '财务-全部订单-退款-删除',
                        'slug' => 'order.refund.delete',
                        'method' => 'DELETE',
                        'url' => 'order/refund/\d+',
                        'sort' => 6006,
                    ],
                ],
            ],

            // 运营
            [
                'group_name' => '运营',
                'sort' => 7000,
                'children' => [
                    // 课程评论
                    [
                        'display_name' => '运营-课程评论-列表',
                        'slug' => 'comment.index',
                        'method' => 'GET',
                        'url' => 'comment/index',
                        'sort' => 7000,
                    ],
                    [
                        'display_name' => '运营-课程评论-删除',
                        'slug' => 'comment.delete',
                        'method' => 'POST',
                        'url' => 'comment/delete',
                        'sort' => 7001,
                    ],
                    [
                        'display_name' => '运营-课程评论-审核',
                        'slug' => 'comment.check',
                        'method' => 'POST',
                        'url' => 'comment/check',
                        'sort' => 7002,
                    ],

                    // VIP会员
                    [
                        'display_name' => '运营-VIP会员-列表',
                        'slug' => 'role',
                        'method' => 'GET',
                        'url' => 'role/index',
                        'sort' => 7003,
                    ],
                    [
                        'display_name' => '运营-VIP会员-添加',
                        'slug' => 'role.store',
                        'method' => 'GET|POST',
                        'url' => 'role/create',
                        'sort' => 7004,
                    ],
                    [
                        'display_name' => '运营-VIP会员-编辑',
                        'slug' => 'role.update',
                        'method' => 'GET|PUT',
                        'url' => 'role/\d+',
                        'sort' => 7005,
                    ],
                    [
                        'display_name' => '运营-VIP会员-删除',
                        'slug' => 'role.destroy',
                        'method' => 'DELETE',
                        'url' => 'role/\d+',
                        'sort' => 7006,
                    ],

                    // 优惠码
                    [
                        'display_name' => '运营-优惠码-列表',
                        'slug' => 'promoCode',
                        'method' => 'GET',
                        'url' => 'promoCode',
                        'sort' => 7007,
                    ],
                    [
                        'display_name' => '运营-优惠码-添加',
                        'slug' => 'promoCode.store',
                        'method' => 'POST',
                        'url' => '(^promoCode$|^promoCode\/import$)',
                        'sort' => 7008,
                    ],
                    [
                        'display_name' => '运营-优惠码-编辑',
                        'slug' => 'promoCode.update',
                        'method' => 'GET|PUT',
                        'url' => 'promoCode/\d+',
                        'sort' => 7009,
                    ],
                    [
                        'display_name' => '运营-优惠码-删除',
                        'slug' => 'promoCode.destroy.multi',
                        'method' => 'POST',
                        'url' => 'promoCode/delete/multi',
                        'sort' => 7010,
                    ],
                    [
                        'display_name' => '运营-优惠码-批量生成',
                        'slug' => 'promoCode.generator',
                        'method' => 'POST',
                        'url' => 'promoCode/generator',
                        'sort' => 7011,
                    ],

                    // 协议管理
                    [
                        'display_name' => '运营-协议管理-增改删',
                        'slug' => 'agreements',
                        'method' => 'GET|POST|PUT|DELETE',
                        'url' => '(^agreement/index$|^agreement/create$|^agreement/\d+$)',
                        'sort' => 7012,
                    ],
                    [
                        'display_name' => '运营-协议管理-同意记录',
                        'slug' => 'agreements.records',
                        'method' => 'GET',
                        'url' => 'agreement/\d+/records',
                        'sort' => 7013,
                    ],

                    // 公告
                    [
                        'display_name' => '运营-公告管理-列表',
                        'slug' => 'announcement',
                        'method' => 'GET',
                        'url' => 'announcement/index',
                        'sort' => 7014,
                    ],
                    [
                        'display_name' => '运营-公告管理-添加',
                        'slug' => 'announcement.store',
                        'method' => 'POST',
                        'url' => 'announcement/create',
                        'sort' => 7015,
                    ],
                    [
                        'display_name' => '运营-公告管理-编辑',
                        'slug' => 'announcement.update',
                        'method' => 'GET|PUT',
                        'url' => 'announcement/\d+',
                        'sort' => 7016,
                    ],
                    [
                        'display_name' => '运营-公告管理-删除',
                        'slug' => 'announcement.destroy',
                        'method' => 'DELETE',
                        'url' => 'announcement/\d+',
                        'sort' => 7017,
                    ],
                ],
            ],

            // 数据
            [
                'group_name' => '数据',
                'sort' => 8000,
                'children' => [
                    [
                        'display_name' => '数据-交易数据',
                        'slug' => 'stats.transaction',
                        'method' => 'GET',
                        'url' => '(^stats/transaction$|^stats/transaction-top$|^stats/transaction-graph$)',
                        'sort' => 8000,
                    ],
                    [
                        'display_name' => '数据-商品数据',
                        'slug' => 'stats.course',
                        'method' => 'GET',
                        'url' => '(^stats/transaction-top$)',
                        'sort' => 8010,
                    ],
                    [
                        'display_name' => '数据-学员数据',
                        'slug' => 'stats.user',
                        'method' => 'GET',
                        'url' => '(^stats/user$|^stats/user-top$|^stats/user-paid-top$|^stats/user-graph$)',
                        'sort' => 8020,
                    ],
                ],
            ],

            // 系统
            [
                'group_name' => '系统',
                'sort' => 9000,
                'children' => [
                    // 管理员
                    [
                        'display_name' => '系统-管理人员-列表',
                        'slug' => 'administrator',
                        'method' => 'GET',
                        'url' => 'administrator/index',
                        'sort' => 9000,
                    ],
                    [
                        'display_name' => '系统-管理人员-添加',
                        'slug' => 'administrator.store',
                        'method' => 'GET|POST',
                        'url' => 'administrator/create',
                        'sort' => 9001,
                    ],
                    [
                        'display_name' => '系统-管理人员-编辑',
                        'slug' => 'administrator.update',
                        'method' => 'GET|PUT',
                        'url' => 'administrator/\d+',
                        'sort' => 9002,
                    ],
                    [
                        'display_name' => '系统-管理人员-删除',
                        'slug' => 'administrator.destroy',
                        'method' => 'DELETE',
                        'url' => 'administrator/\d+',
                        'sort' => 9003,
                    ],

                    // 管理员角色
                    [
                        'display_name' => '系统-管理人员-角色-列表',
                        'slug' => 'administrator_role',
                        'method' => 'GET',
                        'url' => 'administrator_role/index',
                        'sort' => 9004,
                    ],
                    [
                        'display_name' => '系统-管理人员-角色-添加',
                        'slug' => 'administrator_role.store',
                        'method' => 'GET|POST',
                        'url' => 'administrator_role/create',
                        'sort' => 9005,
                    ],
                    [
                        'display_name' => '系统-管理人员-角色-编辑',
                        'slug' => 'administrator_role.update',
                        'method' => 'GET|PUT',
                        'url' => 'administrator_role/\d+',
                        'sort' => 9006,
                    ],
                    [
                        'display_name' => '系统-管理人员-角色-删除',
                        'slug' => 'administrator_role.destroy',
                        'method' => 'DELETE',
                        'url' => 'administrator_role/\d+',
                        'sort' => 9007,
                    ],

                    // 系统配置
                    [
                        'display_name' => '系统-系统配置-查看',
                        'slug' => 'setting',
                        'method' => 'GET',
                        'url' => 'setting',
                        'sort' => 9008,
                    ],
                    [
                        'display_name' => '系统-系统配置-保存',
                        'slug' => 'setting.save',
                        'method' => 'POST',
                        'url' => 'setting',
                        'sort' => 9009,
                    ],

                    // 审计日志
                    [
                        'display_name' => '系统-系统日志-查看',
                        'slug' => 'system.audit.log',
                        'method' => 'GET',
                        'url' => '(^log/admin$|^log/userLogin$|^log/uploadImages$|^log/runtime$)',
                        'sort' => 9010,
                    ],
                    [
                        'display_name' => '系统-系统日志-清空',
                        'slug' => 'system.audit.log.clear',
                        'method' => 'DELETE',
                        'url' => 'log/\s+',
                        'sort' => 9011,
                    ],
                ],
            ],

            // 字段权限
            [
                'group_name' => '字段权限',
                'sort' => 10000,
                'children' => [
                    [
                        'display_name' => '字段权限-学员-手机号',
                        'slug' => BackendApiConstant::P_DATA_USER_MOBILE,
                        'method' => 'DATA',
                        'url' => '',
                        'sort' => 10000,
                    ],
                    [
                        'display_name' => '字段权限-学员-真实姓名',
                        'slug' => BackendApiConstant::P_DATA_USER_REAL_NAME,
                        'method' => 'DATA',
                        'url' => '',
                        'sort' => 10001,
                    ],
                    [
                        'display_name' => '字段权限-学员-身份证号',
                        'slug' => BackendApiConstant::P_DATA_USER_ID_NUMBER,
                        'method' => 'DATA',
                        'url' => '',
                        'sort' => 10002,
                    ],
                    [
                        'display_name' => '字段权限-管理员-邮箱',
                        'slug' => BackendApiConstant::P_DATA_ADMINISTRATOR_EMAIL,
                        'method' => 'DATA',
                        'url' => '',
                        'sort' => 10003,
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
