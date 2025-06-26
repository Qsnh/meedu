<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Constant;

class ApiV2Constant
{
    public const MODEL_COURSE_FIELD = [
        'id', 'title', 'slug', 'thumb', 'charge', 'short_description', 'render_desc', 'seo_keywords',
        'seo_description', 'published_at', 'is_rec', 'is_show', 'user_count', 'category_id', 'is_free',
        'is_allow_comment', 'is_vip_free',

        // 额外字段
        'videos_count', 'category',
    ];

    public const MODEL_VIDEO_FIELD = [
        'id', 'course_id', 'title', 'slug', 'view_num', 'seo_keywords', 'seo_description',
        'published_at', 'charge', 'chapter_id', 'duration', 'is_ban_sell', 'free_seconds',
        'ban_drag', 'is_allow_comment',
    ];

    public const MODEL_MEMBER_FIELD = [
        'id', 'avatar', 'nick_name', 'mobile', 'is_lock', 'is_active', 'role_id', 'role_expired_at',
        'invite_balance', 'is_password_set', 'is_set_nickname',
        'created_at', 'credit1', 'credit2', 'credit3', 'role',
    ];

    public const MODEL_MEMBER_SIMPLE = [
        'id', 'avatar', 'nick_name',
    ];

    public const MODEL_ROLE_FIELD = [
        'id', 'name', 'charge', 'expire_days', 'desc_rows',
    ];

    public const MODEL_COURSE_CHAPTER_FIELD = [
        'id', 'course_id', 'title',
    ];

    public const MODEL_COURSE_CATEGORY_FIELD = [
        'id', 'name', 'parent_id', 'children',
    ];

    public const MODEL_COURSE_COMMENT_FIELD = [
        'id', 'user_id', 'render_content', 'created_at', 'ip', 'ip_province', 'is_check',
    ];

    public const MODEL_VIDEO_COMMENT_FIELD = [
        'id', 'user_id', 'render_content', 'created_at', 'ip', 'ip_province', 'is_check',
    ];

    public const MODEL_ORDER_FIELD = [
        'id', 'user_id', 'charge', 'order_id', 'payment_method', 'status_text', 'payment_text', 'continue_pay',
        'goods', 'created_at',
    ];

    public const MODEL_ORDER_GOODS_FIELD = [
        'num', 'goods_text', 'charge', 'goods_type', 'goods_name', 'goods_thumb', 'goods_id', 'goods_charge',
        'goods_ori_charge',
    ];

    public const MODEL_PROMO_CODE_FIELD = [
        'id', 'code', 'expired_at', 'invited_user_reward', 'invite_user_reward',
    ];

    public const MODEL_SLIDER_FIELD = [
        'thumb', 'url', 'sort', 'platform',
    ];

    public const MODEL_NOTIFICATON_FIELD = [
        'id', 'notifiable_id', 'data', 'read_at', 'created_at',
    ];

    public const MODEL_CREDIT1_RECORD_FIELD = [
        'sum', 'remark', 'created_at',
    ];

    public const MODEL_COURSE_ATTACH_FIELD = [
        'id', 'name', 'size', 'extension',
    ];

    public const MODEL_MEMBER_PROFILE_FIELD = [
        'real_name', 'gender', 'age', 'birthday', 'profession', 'address',
        'graduated_school', 'diploma',
        'id_number', 'id_frontend_thumb', 'id_backend_thumb', 'id_hand_thumb',
    ];
}
