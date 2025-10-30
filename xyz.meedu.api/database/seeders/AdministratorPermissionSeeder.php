<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Constant\BackendPermission;

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
                        'slug' => BackendPermission::DASHBOARD,
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
                        'slug' => BackendPermission::DECORATION_PAGE,
                        'sort' => 2000,
                    ],
                    [
                        'display_name' => '装修-页面-添加',
                        'slug' => BackendPermission::DECORATION_PAGE_STORE,
                        'sort' => 2001,
                    ],
                    [
                        'display_name' => '装修-页面-编辑',
                        'slug' => BackendPermission::DECORATION_PAGE_UPDATE,
                        'sort' => 2002,
                    ],
                    [
                        'display_name' => '装修-页面-删除',
                        'slug' => BackendPermission::DECORATION_PAGE_DESTROY,
                        'sort' => 2003,
                    ],
                    [
                        'display_name' => '装修-页面-设置默认',
                        'slug' => BackendPermission::DECORATION_PAGE_SET_DEFAULT,
                        'sort' => 2004,
                    ],
                    [
                        'display_name' => '装修-页面-复制',
                        'slug' => BackendPermission::DECORATION_PAGE_COPY,
                        'sort' => 2005,
                    ],
                    [
                        'display_name' => '装修-页面-装修',
                        'slug' => BackendPermission::DECORATION_PAGE_BLOCKS,
                        'sort' => 2006,
                    ],

                    // 友情链接
                    [
                        'display_name' => '装修-友情链接-列表',
                        'slug' => BackendPermission::LINK,
                        'sort' => 2007,
                    ],
                    [
                        'display_name' => '装修-友情链接-添加',
                        'slug' => BackendPermission::LINK_STORE,
                        'sort' => 2008,
                    ],
                    [
                        'display_name' => '装修-友情链接-编辑',
                        'slug' => BackendPermission::LINK_UPDATE,
                        'sort' => 2009,
                    ],
                    [
                        'display_name' => '装修-友情链接-删除',
                        'slug' => BackendPermission::LINK_DESTROY,
                        'sort' => 2010,
                    ],

                    // PC首页导航
                    [
                        'display_name' => '装修-PC首页导航-列表',
                        'slug' => BackendPermission::NAV,
                        'sort' => 2011,
                    ],
                    [
                        'display_name' => '装修-PC首页导航-添加',
                        'slug' => BackendPermission::NAV_STORE,
                        'sort' => 2012,
                    ],
                    [
                        'display_name' => '装修-PC首页导航-编辑',
                        'slug' => BackendPermission::NAV_UPDATE,
                        'sort' => 2013,
                    ],
                    [
                        'display_name' => '装修-PC首页导航-删除',
                        'slug' => BackendPermission::NAV_DESTROY,
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
                        'slug' => BackendPermission::MEDIA_IMAGE_INDEX,
                        'sort' => 3000,
                    ],
                    [
                        'display_name' => '资源-图片库-上传',
                        'slug' => BackendPermission::MEDIA_IMAGE_STORE,
                        'sort' => 3001,
                    ],
                    [
                        'display_name' => '资源-图片库-删除',
                        'slug' => BackendPermission::MEDIA_IMAGE_DELETE_MULTI,
                        'sort' => 3002,
                    ],

                    // 视频库
                    [
                        'display_name' => '资源-视频库-列表',
                        'slug' => BackendPermission::MEDIA_VIDEO_LIST,
                        'sort' => 3003,
                    ],
                    [
                        'display_name' => '资源-视频库-上传',
                        'slug' => BackendPermission::MEDIA_VIDEO_UPLOAD,
                        'sort' => 3004,
                    ],
                    [
                        'display_name' => '资源-视频库-删除',
                        'slug' => BackendPermission::MEDIA_VIDEO_DELETE_MULTI,
                        'sort' => 3005,
                    ],
                    [
                        'display_name' => '资源-视频库-更换分类',
                        'slug' => BackendPermission::MEDIA_VIDEO_CHANGE_CATEGORY,
                        'sort' => 3006,
                    ],

                    // 视频分类
                    [
                        'display_name' => '资源-视频库-视频分类-添加',
                        'slug' => BackendPermission::MEDIA_VIDEO_CATEGORY_STORE,
                        'sort' => 3007,
                    ],
                    [
                        'display_name' => '资源-视频库-视频分类-编辑',
                        'slug' => BackendPermission::MEDIA_VIDEO_CATEGORY_UPDATE,
                        'sort' => 3008,
                    ],
                    [
                        'display_name' => '资源-视频库-视频分类-删除',
                        'slug' => BackendPermission::MEDIA_VIDEO_CATEGORY_DELETE,
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
                        'slug' => BackendPermission::COURSE_CATEGORY,
                        'sort' => 4000,
                    ],
                    [
                        'display_name' => '课程-录播课-录播课分类-新建',
                        'slug' => BackendPermission::COURSE_CATEGORY_STORE,
                        'sort' => 4001,
                    ],
                    [
                        'display_name' => '课程-录播课-录播课分类-编辑',
                        'slug' => BackendPermission::COURSE_CATEGORY_UPDATE,
                        'sort' => 4002,
                    ],
                    [
                        'display_name' => '课程-录播课-录播课分类-删除',
                        'slug' => BackendPermission::COURSE_CATEGORY_DESTROY,
                        'sort' => 4003,
                    ],

                    // 课程
                    [
                        'display_name' => '课程-录播课',
                        'slug' => BackendPermission::COURSE,
                        'sort' => 4004,
                    ],
                    [
                        'display_name' => '课程-录播课-新建',
                        'slug' => BackendPermission::COURSE_STORE,
                        'sort' => 4005,
                    ],
                    [
                        'display_name' => '课程-录播课-编辑',
                        'slug' => BackendPermission::COURSE_UPDATE,
                        'sort' => 4006,
                    ],
                    [
                        'display_name' => '课程-录播课-删除',
                        'slug' => BackendPermission::COURSE_DESTROY,
                        'sort' => 4007,
                    ],

                    // 课程-录播课-学员-学习记录
                    [
                        'display_name' => '课程-录播课-学员-学习记录',
                        'slug' => BackendPermission::COURSE_WATCH_RECORDS,
                        'sort' => 4008,
                    ],
                    [
                        'display_name' => '课程-录播课-学员-学习记录-删除',
                        'slug' => BackendPermission::COURSE_WATCH_RECORDS_DELETE,
                        'sort' => 4009,
                    ],

                    // 课程-录播课-学员-付费学员
                    [
                        'display_name' => '课程-录播课-学员-付费学员',
                        'slug' => BackendPermission::COURSE_SUBSCRIBES,
                        'sort' => 4010,
                    ],
                    [
                        'display_name' => '课程-录播课-学员-付费学员-添加|批量导入',
                        'slug' => BackendPermission::COURSE_SUBSCRIBE_CREATE,
                        'sort' => 4011,
                    ],
                    [
                        'display_name' => '课程-录播课-学员-付费学员-删除',
                        'slug' => BackendPermission::COURSE_SUBSCRIBE_DELETE,
                        'sort' => 4012,
                    ],

                    // 课程章节
                    [
                        'display_name' => '课程-录播课-课时-章节管理',
                        'slug' => BackendPermission::COURSE_CHAPTER,
                        'sort' => 4013,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-章节管理-新建',
                        'slug' => BackendPermission::COURSE_CHAPTER_STORE,
                        'sort' => 4014,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-章节管理-编辑',
                        'slug' => BackendPermission::COURSE_CHAPTER_UPDATE,
                        'sort' => 4015,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-章节管理-删除',
                        'slug' => BackendPermission::COURSE_CHAPTER_DESTROY,
                        'sort' => 4016,
                    ],

                    // 课时
                    [
                        'display_name' => '课程-录播课-课时',
                        'slug' => BackendPermission::VIDEO,
                        'sort' => 4017,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-新建|批量导入',
                        'slug' => BackendPermission::VIDEO_STORE,
                        'sort' => 4018,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-编辑',
                        'slug' => BackendPermission::VIDEO_UPDATE,
                        'sort' => 4019,
                    ],
                    [
                        'display_name' => '课程-录播课-课时-删除',
                        'slug' => BackendPermission::VIDEO_DESTROY,
                        'sort' => 4020,
                    ],

                    // 课程-录播课-课时-学员
                    [
                        'display_name' => '课程-录播课-课时-学员',
                        'slug' => BackendPermission::VIDEO_WATCH_RECORDS,
                        'sort' => 4021,
                    ],

                    // 课程附件
                    [
                        'display_name' => '课程-录播课-附件',
                        'slug' => BackendPermission::COURSE_ATTACH,
                        'sort' => 4022,
                    ],
                    [
                        'display_name' => '课程-录播课-附件-新建',
                        'slug' => BackendPermission::COURSE_ATTACH_STORE,
                        'sort' => 4023,
                    ],
                    [
                        'display_name' => '课程-录播课-附件-删除',
                        'slug' => BackendPermission::COURSE_ATTACH_DESTROY,
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
                        'slug' => BackendPermission::MEMBER,
                        'sort' => 5000,
                    ],
                    [
                        'display_name' => '学员-学员列表-新建学员|批量导入',
                        'slug' => BackendPermission::MEMBER_STORE,
                        'sort' => 5001,
                    ],
                    [
                        'display_name' => '学员-学员列表-编辑资料|批量设置|冻结/解冻账号',
                        'slug' => BackendPermission::MEMBER_UPDATE,
                        'sort' => 5002,
                    ],
                    [
                        'display_name' => '学员-学员列表-删除账号',
                        'slug' => BackendPermission::MEMBER_DESTROY,
                        'sort' => 5003,
                    ],
                    [
                        'display_name' => '学员-学员列表-编辑资料',
                        'slug' => BackendPermission::MEMBER_REMARK_UPDATE,
                        'sort' => 5004,
                    ],
                    [
                        'display_name' => '学员-学员列表-站内消息|批量发消息',
                        'slug' => BackendPermission::MEMBER_MESSAGE_SEND,
                        'sort' => 5005,
                    ],

                    // 学员-学员列表-详情
                    [
                        'display_name' => '学员-学员列表-详情',
                        'slug' => BackendPermission::MEMBER_DETAIL,
                        'sort' => 5006,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-变动积分',
                        'slug' => BackendPermission::MEMBER_CREDIT1_CHANGE,
                        'sort' => 5007,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-修改备注',
                        'slug' => BackendPermission::MEMBER_REMARK,
                        'sort' => 5008,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-实名信息-重置实名信息',
                        'slug' => BackendPermission::MEMBER_PROFILE_DESTROY,
                        'sort' => 5009,
                    ],

                    // 学员-学员列表-详情-修改标签
                    [
                        'display_name' => '学员-学员列表-详情-修改标签',
                        'slug' => BackendPermission::MEMBER_TAGS,
                        'sort' => 5010,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-修改标签-标签管理',
                        'slug' => BackendPermission::MEMBER_TAG,
                        'sort' => 5011,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-修改标签-标签管理-新建',
                        'slug' => BackendPermission::MEMBER_TAG_STORE,
                        'sort' => 5012,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-修改标签-标签管理-编辑',
                        'slug' => BackendPermission::MEMBER_TAG_UPDATE,
                        'sort' => 5013,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-修改标签-标签管理-删除',
                        'slug' => BackendPermission::MEMBER_TAG_DESTROY,
                        'sort' => 5014,
                    ],

                    [
                        'display_name' => '学员-学员列表-详情-订单明细',
                        'slug' => BackendPermission::MEMBER_DETAIL_USER_ORDERS,
                        'sort' => 5015,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-积分明细',
                        'slug' => BackendPermission::MEMBER_DETAIL_CREDIT1_RECORDS,
                        'sort' => 5016,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-录播课学习',
                        'slug' => BackendPermission::V2_MEMBER_COURSES,
                        'sort' => 5017,
                    ],
                    [
                        'display_name' => '学员-学员列表-详情-录播课学习-学习进度',
                        'slug' => BackendPermission::V2_MEMBER_COURSE_PROGRESS,
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
                        'slug' => BackendPermission::ORDER,
                        'sort' => 6000,
                    ],
                    [
                        'display_name' => '财务-全部订单-详情',
                        'slug' => BackendPermission::ORDER_DETAIL,
                        'sort' => 6001,
                    ],
                    [
                        'display_name' => '财务-全部订单-置为完成',
                        'slug' => BackendPermission::ORDER_FINISH,
                        'sort' => 6002,
                    ],
                    [
                        'display_name' => '财务-全部订单-取消订单',
                        'slug' => BackendPermission::ORDER_CANCEL,
                        'sort' => 6003,
                    ],
                    [
                        'display_name' => '财务-全部订单-退款-列表',
                        'slug' => BackendPermission::ORDER_REFUND_LIST,
                        'sort' => 6004,
                    ],
                    [
                        'display_name' => '财务-全部订单-退款-添加',
                        'slug' => BackendPermission::ORDER_REFUND,
                        'sort' => 6005,
                    ],
                    [
                        'display_name' => '财务-全部订单-退款-删除',
                        'slug' => BackendPermission::ORDER_REFUND_DELETE,
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
                        'slug' => BackendPermission::COMMENT_INDEX,
                        'sort' => 7000,
                    ],
                    [
                        'display_name' => '运营-课程评论-删除',
                        'slug' => BackendPermission::COMMENT_DELETE,
                        'sort' => 7001,
                    ],
                    [
                        'display_name' => '运营-课程评论-审核',
                        'slug' => BackendPermission::COMMENT_CHECK,
                        'sort' => 7002,
                    ],

                    // VIP会员
                    [
                        'display_name' => '运营-VIP会员-列表',
                        'slug' => BackendPermission::ROLE,
                        'sort' => 7003,
                    ],
                    [
                        'display_name' => '运营-VIP会员-添加',
                        'slug' => BackendPermission::ROLE_STORE,
                        'sort' => 7004,
                    ],
                    [
                        'display_name' => '运营-VIP会员-编辑',
                        'slug' => BackendPermission::ROLE_UPDATE,
                        'sort' => 7005,
                    ],
                    [
                        'display_name' => '运营-VIP会员-删除',
                        'slug' => BackendPermission::ROLE_DESTROY,
                        'sort' => 7006,
                    ],

                    // 优惠码
                    [
                        'display_name' => '运营-优惠码-列表',
                        'slug' => BackendPermission::PROMO_CODE,
                        'sort' => 7007,
                    ],
                    [
                        'display_name' => '运营-优惠码-添加',
                        'slug' => BackendPermission::PROMO_CODE_STORE,
                        'sort' => 7008,
                    ],
                    [
                        'display_name' => '运营-优惠码-编辑',
                        'slug' => BackendPermission::PROMO_CODE_UPDATE,
                        'sort' => 7009,
                    ],
                    [
                        'display_name' => '运营-优惠码-删除',
                        'slug' => BackendPermission::PROMO_CODE_DESTROY_MULTI,
                        'sort' => 7010,
                    ],
                    [
                        'display_name' => '运营-优惠码-批量生成',
                        'slug' => BackendPermission::PROMO_CODE_GENERATOR,
                        'sort' => 7011,
                    ],
                    [
                        'display_name' => '运营-优惠码-使用明细',
                        'slug' => BackendPermission::PROMO_CODE_DETAIL,
                        'sort' => 7011,
                    ],


                    // 协议管理
                    [
                        'display_name' => '运营-协议管理-增改删',
                        'slug' => BackendPermission::AGREEMENTS,
                        'sort' => 7012,
                    ],
                    [
                        'display_name' => '运营-协议管理-同意记录',
                        'slug' => BackendPermission::AGREEMENTS_RECORDS,
                        'sort' => 7013,
                    ],

                    // 公告
                    [
                        'display_name' => '运营-公告管理-列表',
                        'slug' => BackendPermission::ANNOUNCEMENT,
                        'sort' => 7014,
                    ],
                    [
                        'display_name' => '运营-公告管理-添加',
                        'slug' => BackendPermission::ANNOUNCEMENT_STORE,
                        'sort' => 7015,
                    ],
                    [
                        'display_name' => '运营-公告管理-编辑',
                        'slug' => BackendPermission::ANNOUNCEMENT_UPDATE,
                        'sort' => 7016,
                    ],
                    [
                        'display_name' => '运营-公告管理-删除',
                        'slug' => BackendPermission::ANNOUNCEMENT_DESTROY,
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
                        'slug' => BackendPermission::STATS_TRANSACTION,
                        'sort' => 8000,
                    ],
                    [
                        'display_name' => '数据-商品数据',
                        'slug' => BackendPermission::STATS_COURSE,
                        'sort' => 8010,
                    ],
                    [
                        'display_name' => '数据-学员数据',
                        'slug' => BackendPermission::STATS_USER,
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
                        'slug' => BackendPermission::ADMINISTRATOR,
                        'sort' => 9000,
                    ],
                    [
                        'display_name' => '系统-管理人员-添加',
                        'slug' => BackendPermission::ADMINISTRATOR_STORE,
                        'sort' => 9001,
                    ],
                    [
                        'display_name' => '系统-管理人员-编辑',
                        'slug' => BackendPermission::ADMINISTRATOR_UPDATE,
                        'sort' => 9002,
                    ],
                    [
                        'display_name' => '系统-管理人员-删除',
                        'slug' => BackendPermission::ADMINISTRATOR_DESTROY,
                        'sort' => 9003,
                    ],

                    // 管理员角色
                    [
                        'display_name' => '系统-管理人员-角色-列表',
                        'slug' => BackendPermission::ADMINISTRATOR_ROLE,
                        'sort' => 9004,
                    ],
                    [
                        'display_name' => '系统-管理人员-角色-添加',
                        'slug' => BackendPermission::ADMINISTRATOR_ROLE_STORE,
                        'sort' => 9005,
                    ],
                    [
                        'display_name' => '系统-管理人员-角色-编辑',
                        'slug' => BackendPermission::ADMINISTRATOR_ROLE_UPDATE,
                        'sort' => 9006,
                    ],
                    [
                        'display_name' => '系统-管理人员-角色-删除',
                        'slug' => BackendPermission::ADMINISTRATOR_ROLE_DESTROY,
                        'sort' => 9007,
                    ],

                    // 系统配置
                    [
                        'display_name' => '系统-系统配置-查看',
                        'slug' => BackendPermission::SETTING,
                        'sort' => 9008,
                    ],
                    [
                        'display_name' => '系统-系统配置-保存',
                        'slug' => BackendPermission::SETTING_SAVE,
                        'sort' => 9009,
                    ],

                    // 审计日志
                    [
                        'display_name' => '系统-系统日志-查看',
                        'slug' => BackendPermission::SYSTEM_AUDIT_LOG,
                        'sort' => 9010,
                    ],
                    [
                        'display_name' => '系统-系统日志-清空',
                        'slug' => BackendPermission::SYSTEM_AUDIT_LOG_CLEAR,
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
                        'slug' => BackendPermission::DATA_USER_MOBILE,
                        'method' => 'DATA',
                        'sort' => 10000,
                    ],
                    [
                        'display_name' => '字段权限-学员-真实姓名',
                        'slug' => BackendPermission::DATA_USER_REAL_NAME,
                        'method' => 'DATA',
                        'sort' => 10001,
                    ],
                    [
                        'display_name' => '字段权限-学员-身份证号',
                        'slug' => BackendPermission::DATA_USER_ID_NUMBER,
                        'method' => 'DATA',
                        'sort' => 10002,
                    ],
                    [
                        'display_name' => '字段权限-管理员-邮箱',
                        'slug' => BackendPermission::DATA_ADMINISTRATOR_EMAIL,
                        'method' => 'DATA',
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
                    'method' => '',
                    'url' => '',
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
