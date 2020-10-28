<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Constant;

class ApiV2Constant
{
    public const YES = 1;

    public const PLEASE_INPUT_IMAGE_CAPTCHA = 'image_captcha.required';
    public const IMAGE_CAPTCHA_ERROR = 'image_captcha_error';

    public const USER_MOBILE_NOT_EXISTS = 'mobile not exists';
    public const MOBILE_OR_PASSWORD_ERROR = 'mobile not exists or password error';
    public const MOBILE_CODE_ERROR = 'mobile code error';

    public const MEMBER_HAS_LOCKED = 'current user was locked,please contact administrator';

    public const VIDEO_NO_AUTH = 'please buy this video before see';

    public const ERROR_CODE = 1;
    public const ERROR_NO_AUTH_CODE = 401;

    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="Course",
     *         type="object",
     *         title="课程",
     *         @OA\Property(property="id",type="integer",description="课程id"),
     *         @OA\Property(property="title",type="string",description="课程标题"),
     *         @OA\Property(property="slug",type="string",description="slug"),
     *         @OA\Property(property="thumb",type="string",description="课程封面"),
     *         @OA\Property(property="charge",type="integer",description="课程价格"),
     *         @OA\Property(property="short_description",type="string",description="简短介绍"),
     *         @OA\Property(property="render_desc",type="string",description="详细介绍"),
     *         @OA\Property(property="published_at",type="string",description="上线时间"),
     *         @OA\Property(property="seo_keywords",type="string",description="seo_keywords"),
     *         @OA\Property(property="seo_description",type="string",description="seo_description"),
     *         @OA\Property(property="category_id",type="integer",description="分类id"),
     *         @OA\Property(property="is_rec",type="integer",description="推荐"),
     *         @OA\Property(property="user_count",type="integer",description="订阅人数"),
     *         @OA\Property(property="videos_count",type="integer",description="视频数量"),
     *         @OA\Property(property="category",type="object",ref="#/components/schemas/CourseCategory")
     *     )
     * )
     */
    public const MODEL_COURSE_FIELD = [
        'id', 'title', 'slug', 'thumb', 'charge', 'short_description', 'render_desc', 'seo_keywords',
        'seo_description', 'published_at', 'is_rec', 'user_count', 'videos_count', 'category',
    ];

    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="Video",
     *         type="object",
     *         title="视频",
     *         @OA\Property(property="id",type="integer",description="id"),
     *         @OA\Property(property="course_id",type="integer",description="课程id"),
     *         @OA\Property(property="title",type="string",description="视频标题"),
     *         @OA\Property(property="slug",type="string",description="slug"),
     *         @OA\Property(property="charge",type="integer",description="视频价格"),
     *         @OA\Property(property="view_num",type="integer",description="观看次数"),
     *         @OA\Property(property="short_description",type="string",description="简短介绍"),
     *         @OA\Property(property="render_desc",type="string",description="详细介绍"),
     *         @OA\Property(property="published_at",type="string",description="上线时间"),
     *         @OA\Property(property="duration",type="integer",description="视频时长，单位：秒"),
     *         @OA\Property(property="seo_keywords",type="integer",description="seo_keywords"),
     *         @OA\Property(property="seo_description",type="integer",description="seo_description"),
     *         @OA\Property(property="chapter_id",type="integer",description="章节id"),
     *         @OA\Property(property="is_ban_sell",type="integer",description="禁止销售，1是，0否"),
     *     ),
     * )
     */
    public const MODEL_VIDEO_FIELD = [
        'id', 'course_id', 'title', 'slug', 'view_num', 'short_description', 'render_desc', 'seo_keywords',
        'seo_description', 'published_at', 'charge', 'chapter_id', 'duration', 'is_ban_sell',
    ];
    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="User",
     *         type="object",
     *         title="用户信息",
     *         @OA\Property(property="id",type="integer",description="用户id"),
     *         @OA\Property(property="avatar",type="string",description="头像"),
     *         @OA\Property(property="nick_name",type="string",description="昵称"),
     *         @OA\Property(property="mobile",type="string",description="手机号"),
     *         @OA\Property(property="credit1",type="int",description="积分"),
     *         @OA\Property(property="role_id",type="integer",description="会员套餐id"),
     *         @OA\Property(property="role_expired_at",type="string",description="会员套餐到期时间"),
     *         @OA\Property(property="role",type="object",ref="#/components/schemas/Role"),
     *         @OA\Property(property="invite_balance",type="integer",description="邀请余额"),
     *         @OA\Property(property="is_password_set",type="integer",description="是否配置了密码"),
     *         @OA\Property(property="is_set_nickname",type="integer",description="是否设置了昵称"),
     *     ),
     * )
     */
    public const MODEL_MEMBER_FIELD = [
        'id', 'avatar', 'nick_name', 'mobile', 'is_lock', 'is_active', 'role_id', 'role_expired_at',
        'invite_balance', 'role', 'is_password_set', 'is_set_nickname', 'credit1',
    ];
    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="Role",
     *         type="object",
     *         title="会员套餐",
     *         @OA\Property(property="id",type="integer",description="套餐id"),
     *         @OA\Property(property="name",type="string",description="套餐名"),
     *         @OA\Property(property="charge",type="integer",description="套餐价格"),
     *         @OA\Property(property="expire_days",type="integer",description="套餐天数"),
     *         @OA\Property(property="desc_rows",type="array",description="套餐描述",@OA\Items(@OA\Property(type="string"))),
     *     ),
     * )
     */
    public const MODEL_ROLE_FIELD = [
        'id', 'name', 'charge', 'expire_days', 'desc_rows',
    ];
    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="CourseChapter",
     *         type="object",
     *         title="课程章节",
     *         @OA\Property(property="id",type="integer",description="id"),
     *         @OA\Property(property="course_id",type="integer",description="课程id"),
     *         @OA\Property(property="title",type="string",description="章节名"),
     *     ),
     * )
     */
    public const MODEL_COURSE_CHAPTER_FIELD = [
        'id', 'course_id', 'title',
    ];


    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="CourseCategory",
     *         type="object",
     *         title="课程分类",
     *         @OA\Property(property="id",type="integer",description="id"),
     *         @OA\Property(property="name",type="string",description="分类名"),
     *         @OA\Property(property="parent_id",type="integer",description="父id"),
     *     ),
     * )
     */
    public const MODEL_COURSE_CATEGORY_FIELD = [
        'id', 'name', 'parent_id',
    ];


    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="CourseComment",
     *         type="object",
     *         title="课程评论",
     *         @OA\Property(property="id",type="integer",description="id"),
     *         @OA\Property(property="user_id",type="integer",description="用户id"),
     *         @OA\Property(property="render_content",type="string",description="评论内容"),
     *         @OA\Property(property="created_at",type="string",description="时间"),
     *     ),
     * )
     */
    public const MODEL_COURSE_COMMENT_FIELD = [
        'id', 'user_id', 'render_content', 'created_at',
    ];

    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="VideoComment",
     *         type="object",
     *         title="视频评论",
     *         @OA\Property(property="id",type="integer",description="id"),
     *         @OA\Property(property="user_id",type="integer",description="用户id"),
     *         @OA\Property(property="render_content",type="string",description="评论内容"),
     *         @OA\Property(property="created_at",type="string",description="时间"),
     *     ),
     * )
     */
    public const MODEL_VIDEO_COMMENT_FIELD = [
        'id', 'user_id', 'render_content', 'created_at',
    ];

    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="Order",
     *         type="object",
     *         title="订单",
     *         @OA\Property(property="id",type="integer",description="id"),
     *         @OA\Property(property="user_id",type="integer",description="用户id"),
     *         @OA\Property(property="charge",type="integer",description="总价"),
     *         @OA\Property(property="order_id",type="string",description="订单编号"),
     *         @OA\Property(property="payment_method",type="string",description="支付方式"),
     *         @OA\Property(property="payment_text",type="string",description="支付渠道文本"),
     *         @OA\Property(property="continue_pay",type="boolean",description="是否可以继续支付"),
     *         @OA\Property(property="goods",type="array",description="商品",@OA\Items(ref="#/components/schemas/OrderGoods")),
     *         @OA\Property(property="status_text",type="string",description="状态文本"),
     *         @OA\Property(property="created_at",type="string",description="时间"),
     *     ),
     * )
     */
    public const MODEL_ORDER_FIELD = [
        'id', 'user_id', 'charge', 'order_id', 'payment_method', 'status_text', 'payment_text', 'continue_pay',
        'goods', 'created_at',
    ];
    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="OrderGoods",
     *         type="object",
     *         title="订单商品",
     *         @OA\Property(property="num",type="integer",description="订购数量"),
     *         @OA\Property(property="goods_text",type="integer",description="商品名"),
     *         @OA\Property(property="charge",type="string",description="价格"),
     *         @OA\Property(property="goods_type",type="string",description="商品类型"),
     *     ),
     * )
     */
    public const MODEL_ORDER_GOODS_FIELD = [
        'num', 'goods_text', 'charge', 'goods_type',
    ];

    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="PromoCode",
     *         type="object",
     *         title="优惠码",
     *         @OA\Property(property="id",type="integer",description="id"),
     *         @OA\Property(property="code",type="string",description="优惠码"),
     *         @OA\Property(property="expired_at",type="string",description="过期时间"),
     *         @OA\Property(property="invited_user_reward",type="integer",description="被邀请奖励"),
     *     ),
     * )
     */
    public const MODEL_PROMO_CODE_FIELD = [
        'id', 'code', 'expired_at', 'invited_user_reward', 'invite_user_reward',
    ];

    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="Slider",
     *         type="object",
     *         title="幻灯片",
     *         @OA\Property(property="thumb",type="string",description="图片"),
     *         @OA\Property(property="url",type="string",description="url"),
     *         @OA\Property(property="sort",type="integer",description="升序"),
     *     ),
     * )
     */
    public const MODEL_SLIDER_FIELD = [
        'thumb', 'url', 'sort', 'platform',
    ];

    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="Notification",
     *         type="object",
     *         title="消息",
     *         @OA\Property(property="id",type="string",description="消息id"),
     *         @OA\Property(property="notifiable_id",type="integer",description="notifiable_id"),
     *         @OA\Property(property="read_at",type="string",description="read_at"),
     *         @OA\Property(property="created_at",type="string",description="created_at"),
     *         @OA\Property(property="data",type="array",@OA\Items(@OA\Property(type="message"))),
     *     ),
     * )
     */
    public const MODEL_NOTIFICATON_FIELD = [
        'id', 'notifiable_id', 'data', 'read_at', 'created_at',
    ];

    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="UserCredit1Record",
     *         type="object",
     *         title="积分明细",
     *         @OA\Property(property="sum",type="integer",description="变动"),
     *         @OA\Property(property="remark",type="string",description="说明"),
     *         @OA\Property(property="created_at",type="integer",description="时间"),
     *     ),
     * )
     */
    public const MODEL_CREDIT1_RECORD_FIELD = [
        'sum', 'remark', 'created_at',
    ];

    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="CourseAttach",
     *         type="object",
     *         title="课程附件",
     *         @OA\Property(property="id",type="integer",description="id"),
     *         @OA\Property(property="name",type="string",description="附件名"),
     *         @OA\Property(property="size",type="integer",description="附件大小，单位：字节"),
     *         @OA\Property(property="extension",type="string",description="附件扩展"),
     *     ),
     * )
     */
    public const MODEL_COURSE_ATTACH_FIELD = [
        'id', 'name', 'size', 'extension',
    ];

    /**
     * @OpenApi\Annotations\Schemas(
     *     @OA\Schema(
     *         schema="MemberProfile",
     *         type="object",
     *         title="用户资料",
     *         @OA\Property(property="real_name",type="string",description="真实姓名"),
     *         @OA\Property(property="age",type="integer",description="年龄"),
     *         @OA\Property(property="gender",type="string",description="性别"),
     *         @OA\Property(property="birthday",type="string",description="生日"),
     *         @OA\Property(property="profession",type="string",description="职业"),
     *         @OA\Property(property="address",type="string",description="住址"),
     *         @OA\Property(property="graduated_school",type="string",description="毕业院校"),
     *         @OA\Property(property="diploma",type="string",description="毕业证书照"),
     *         @OA\Property(property="id_number",type="string",description="身份证号"),
     *         @OA\Property(property="id_frontend_thumb",type="string",description="身份证正面照"),
     *         @OA\Property(property="id_backend_thumb",type="string",description="身份证反面照"),
     *         @OA\Property(property="id_hand_thumb",type="string",description="手持身份证照"),
     *     ),
     * )
     */
    public const MODEL_MEMBER_PROFILE_FIELD = [
        'real_name', 'gender', 'age', 'birthday', 'profession', 'address',
        'graduated_school', 'diploma',
        'id_number', 'id_frontend_thumb', 'id_backend_thumb', 'id_hand_thumb',
    ];
}
