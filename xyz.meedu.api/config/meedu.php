<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

return [

    // 关于我们
    'aboutus' => '',

    // 会员配置
    'member' => [
        'is_active_default' => 1,//注册学员默认激活[1:是,0:否]
        'is_lock_default' => 0,//注册学员默认锁定[1:是,0:否]

        // 用户协议
        'protocol' => '',
        // 隐私协议
        'private_protocol' => '',
        // 会员服务协议=>购买VIP会员需要先同意此协议
        'vip_protocol' => '',

        // 强制用户绑定手机号[1:是,0:否]
        'enabled_mobile_bind_alert' => 0,

        // 强制用户实名认证
        'enabled_face_verify' => 0,

        // 头像
        'default_avatar' => '/images/default_avatar.jpg',

        // Socialite
        'socialite' => [
            'qq' => [
                'app' => 'qq',
                'name' => 'QQ',
                'logo' => '/images/icons/qq.svg',
                'enabled' => 0,
            ],
        ],

        // Invite
        'invite' => [
            // 免费用户是否可以邀请
            'free_user_enabled' => false,
            // 邀请用户奖励
            'invite_user_reward' => 0,
            // 被邀请用户奖励
            'invited_user_reward' => 0,
            // 上下级关系持续时间
            'effective_days' => 365,
            // 邀请余额是否可以支付
            'invite_balance_can_pay' => 1,
            // 订单抽成
            'per_order_draw' => 0.01,
        ],

        // 积分
        'credit1' => [
            // 注册送
            'register' => 0,
            // 看完课程
            'watched_course' => 0,
            // 看完视频
            'watched_video' => 0,
            // 支付订单
            'paid_order' => 0,
            // 邀请用户
            'invite' => 0,
        ],

        // 注册送VIP
        'register' => [
            'vip' => [
                // 开启[1:是,0否]
                'enabled' => 0,
                // VIP[id]
                'role_id' => 0,
                // 赠送天数
                'days' => 0,
            ]
        ],
    ],

    // 上传
    'upload' => [
        'video' => [
            'default_service' => '',
            'aliyun' => [
                'region' => '',
                'host' => '',
                'access_key_id' => '',
                'access_key_secret' => '',
                'callback_key' => '',
                'play_domain' => '',
                'play_key' => '',
            ],
        ],
    ],

    // 管理员配置
    'administrator' => [
        'super_slug' => 'administrator',
    ],

    // 支付网关
    'payment' => [
        'alipay' => [
            'enabled' => 0,
        ],
        'wechat' => [
            'enabled' => 0,
        ],
        'handPay' => [
            'enabled' => 0,
        ],
    ],

    // 系统配置
    'system' => [
        // 网站名
        'name' => '',
        // ICP备案
        'icp' => '',
        'icp_link' => '',
        // 公安网备案
        'icp2' => '',
        'icp2_link' => '',
        // 网站logo
        'logo' => '/images/logo.png',
        // 播放器封面
        'player_thumb' => '/images/player-thumb.png',
        // PC网站地址
        'pc_url' => '',
        // H5网站地址
        'h5_url' => '',

        // 播放器
        'player' => [
            // 跑马灯
            'enabled_bullet_secret' => 0,
            'bullet_secret' => [
                'text' => '', //默认为当前用户手机号
                'size' => 0, //默认14px
                'color' => '', //默认red
                'opacity' => 1, //默认1
            ],
        ],

        // 缓存开关
        'cache' => [
            'status' => (int)env('MEEDU_CACHE_ENABLED', 0),
            'expire' => 3600 * 10,
        ],

        // 短信频率
        'limiter' => [
            'sms' => [
                'times' => 6,
                'minutes' => 1,
            ]
        ],

        // 默认短信服务商
        'sms' => 'aliyun',

        // 登录
        'login' => [
            'limit' => [
                'rule' => \App\Constant\FrontendConstant::LOGIN_LIMIT_RULE_DEFAULT,
            ]
        ],

        // 多语言
        'lang' => \App\Constant\FrontendConstant::LANG_ZH,

        // 关闭deprecated的API访问
        'close_deprecated_api' => env('CLOSE_DEPRECATED_API', false),
    ],

    // MeEduCloud
    'meeducloud' => [
        'domain' => env('MEEDUCLOUD_DOMAIN', 'https://meedu.vip'),
        'user_id' => env('MEEDUCLOUD_USER_ID'),
        'password' => env('MEEDUCLOUD_PASSWORD'),
    ],

    // 微信公众号配置
    'mp_wechat' => [
        'app_id' => '',
        'app_secret' => '',
        'token' => '',
        // 开启授权登录
        'enabled_oauth_login' => 0,
        // 微信H5分享自定义内容
        'share' => [
            // 是否开启
            'enabled' => 0,
            // 分享标题
            'title' => '',
            // 分享描述
            'desc' => '',
            // 分享的图片
            'imgUrl' => '',
        ],
    ],
];
