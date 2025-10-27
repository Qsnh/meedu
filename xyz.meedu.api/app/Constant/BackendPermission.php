<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Constant;

/**
 * 后台权限常量
 *
 * 包含所有后台接口权限和字段权限的 slug 定义
 * 用于路由中间件、权限检查和权限 Seeder
 */
class BackendPermission
{
    // ==================== 主面板 ====================
    public const DASHBOARD = 'dashboard';

    // ==================== 装修 ====================
    // 装修-页面
    public const DECORATION_PAGE = 'decorationPage';
    public const DECORATION_PAGE_STORE = 'decorationPage.store';
    public const DECORATION_PAGE_UPDATE = 'decorationPage.update';
    public const DECORATION_PAGE_DESTROY = 'decorationPage.destroy';
    public const DECORATION_PAGE_SET_DEFAULT = 'decorationPage.setDefault';
    public const DECORATION_PAGE_COPY = 'decorationPage.copy';
    public const DECORATION_PAGE_BLOCKS = 'decorationPage.blocks';

    // 友情链接
    public const LINK = 'link';
    public const LINK_STORE = 'link.store';
    public const LINK_UPDATE = 'link.update';
    public const LINK_DESTROY = 'link.destroy';

    // PC首页导航
    public const NAV = 'nav';
    public const NAV_STORE = 'nav.store';
    public const NAV_UPDATE = 'nav.update';
    public const NAV_DESTROY = 'nav.destroy';

    // ==================== 资源 ====================
    // 图片库
    public const MEDIA_IMAGE_INDEX = 'media.image.index';
    public const MEDIA_IMAGE_STORE = 'media.image.store';
    public const MEDIA_IMAGE_DELETE_MULTI = 'media.image.delete.multi';

    // 视频库
    public const MEDIA_VIDEO_LIST = 'media.video.list';
    public const MEDIA_VIDEO_UPLOAD = 'media.video.upload';
    public const MEDIA_VIDEO_DELETE_MULTI = 'media.video.delete.multi';
    public const MEDIA_VIDEO_CHANGE_CATEGORY = 'media.video.change-category';

    // 视频分类
    public const MEDIA_VIDEO_CATEGORY_STORE = 'media.video-category.store';
    public const MEDIA_VIDEO_CATEGORY_UPDATE = 'media.video-category.update';
    public const MEDIA_VIDEO_CATEGORY_DELETE = 'media.video-category.delete';

    // ==================== 课程 ====================
    // 录播课分类
    public const COURSE_CATEGORY = 'courseCategory';
    public const COURSE_CATEGORY_STORE = 'courseCategory.store';
    public const COURSE_CATEGORY_UPDATE = 'courseCategory.update';
    public const COURSE_CATEGORY_DESTROY = 'courseCategory.destroy';

    // 录播课
    public const COURSE = 'course';
    public const COURSE_STORE = 'course.store';
    public const COURSE_UPDATE = 'course.update';
    public const COURSE_DESTROY = 'course.destroy';
    public const COURSE_WATCH_RECORDS = 'course.watchRecords';
    public const COURSE_WATCH_RECORDS_DELETE = 'course.watchRecords.delete';
    public const COURSE_SUBSCRIBES = 'course.subscribes';
    public const COURSE_SUBSCRIBE_CREATE = 'course.subscribe.create';
    public const COURSE_SUBSCRIBE_DELETE = 'course.subscribe.delete';

    // 课程章节
    public const COURSE_CHAPTER = 'course_chapter';
    public const COURSE_CHAPTER_STORE = 'course_chapter.store';
    public const COURSE_CHAPTER_UPDATE = 'course_chapter.update';
    public const COURSE_CHAPTER_DESTROY = 'course_chapter.destroy';

    // 课时
    public const VIDEO = 'video';
    public const VIDEO_STORE = 'video.store';
    public const VIDEO_UPDATE = 'video.update';
    public const VIDEO_DESTROY = 'video.destroy';
    public const VIDEO_WATCH_RECORDS = 'video.watch.records';

    // 课程附件
    public const COURSE_ATTACH = 'course_attach';
    public const COURSE_ATTACH_STORE = 'course_attach.store';
    public const COURSE_ATTACH_DESTROY = 'course_attach.destroy';

    // ==================== 学员 ====================
    public const MEMBER = 'member';
    public const MEMBER_STORE = 'member.store';
    public const MEMBER_UPDATE = 'member.update';
    public const MEMBER_DESTROY = 'member.destroy';
    public const MEMBER_REMARK = 'member.remark';
    public const MEMBER_REMARK_UPDATE = 'member.remark.update';
    public const MEMBER_MESSAGE_SEND = 'member.message.send';
    public const MEMBER_DETAIL = 'member.detail';
    public const MEMBER_DETAIL_USER_ORDERS = 'member.detail.userOrders';
    public const MEMBER_DETAIL_CREDIT1_RECORDS = 'member.detail.credit1Records';
    public const MEMBER_CREDIT1_CHANGE = 'member.credit1.change';
    public const MEMBER_PROFILE_DESTROY = 'member.profile.destroy';
    public const MEMBER_TAGS = 'member.tags';
    public const MEMBER_TAG = 'member.tag';
    public const MEMBER_TAG_STORE = 'member.tag.store';
    public const MEMBER_TAG_UPDATE = 'member.tag.update';
    public const MEMBER_TAG_DESTROY = 'member.tag.destroy';

    // 学员-V2接口
    public const V2_MEMBER_COURSES = 'v2.member.courses';
    public const V2_MEMBER_COURSE_PROGRESS = 'v2.member.course.progress';

    // ==================== 财务 ====================
    public const ORDER = 'order';
    public const ORDER_DETAIL = 'order.detail';
    public const ORDER_FINISH = 'order.finish';
    public const ORDER_CANCEL = 'order.cancel';
    public const ORDER_REFUND = 'order.refund';
    public const ORDER_REFUND_LIST = 'order.refund.list';
    public const ORDER_REFUND_DELETE = 'order.refund.delete';

    // ==================== 运营 ====================
    // 课程评论
    public const COMMENT_INDEX = 'comment.index';
    public const COMMENT_DELETE = 'comment.delete';
    public const COMMENT_CHECK = 'comment.check';

    // VIP会员
    public const ROLE = 'role';
    public const ROLE_STORE = 'role.store';
    public const ROLE_UPDATE = 'role.update';
    public const ROLE_DESTROY = 'role.destroy';

    // 优惠码
    public const PROMO_CODE = 'promoCode';
    public const PROMO_CODE_STORE = 'promoCode.store';
    public const PROMO_CODE_UPDATE = 'promoCode.update';
    public const PROMO_CODE_DESTROY_MULTI = 'promoCode.destroy.multi';
    public const PROMO_CODE_GENERATOR = 'promoCode.generator';

    // 协议管理
    public const AGREEMENTS = 'agreements';
    public const AGREEMENTS_RECORDS = 'agreements.records';

    // 公告
    public const ANNOUNCEMENT = 'announcement';
    public const ANNOUNCEMENT_STORE = 'announcement.store';
    public const ANNOUNCEMENT_UPDATE = 'announcement.update';
    public const ANNOUNCEMENT_DESTROY = 'announcement.destroy';

    // ==================== 数据 ====================
    public const STATS_TRANSACTION = 'stats.transaction';
    public const STATS_COURSE = 'stats.course';
    public const STATS_USER = 'stats.user';

    // ==================== 系统 ====================
    // 管理人员
    public const ADMINISTRATOR = 'administrator';
    public const ADMINISTRATOR_STORE = 'administrator.store';
    public const ADMINISTRATOR_UPDATE = 'administrator.update';
    public const ADMINISTRATOR_DESTROY = 'administrator.destroy';

    // 管理人员-角色
    public const ADMINISTRATOR_ROLE = 'administrator_role';
    public const ADMINISTRATOR_ROLE_STORE = 'administrator_role.store';
    public const ADMINISTRATOR_ROLE_UPDATE = 'administrator_role.update';
    public const ADMINISTRATOR_ROLE_DESTROY = 'administrator_role.destroy';

    // 系统配置
    public const SETTING = 'setting';
    public const SETTING_SAVE = 'setting.save';

    // 系统日志
    public const SYSTEM_AUDIT_LOG = 'system.audit.log';
    public const SYSTEM_AUDIT_LOG_CLEAR = 'system.audit.log.clear';

    // 超管专属权限（代码级别，不存储在数据库）
    public const SUPER_ADMIN_ONLY = 'super_admin_only';

    // ==================== 字段权限 ====================
    public const DATA_USER_MOBILE = 'data.user.mobile';
    public const DATA_USER_ID_NUMBER = 'data.user.id_number';
    public const DATA_USER_REAL_NAME = 'data.user.real_name';
    public const DATA_ADMINISTRATOR_EMAIL = 'data.administrator.email';
}
