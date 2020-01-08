<?php

return [

    // 配置文件存储路径
    'save' => storage_path('/meedu_config.json'),

    // 会员配置
    'member' => [
        'is_active_default' => \App\User::ACTIVE_NO,
        'is_lock_default' => \App\User::LOCK_NO,

        // 头像
        'default_avatar' => '/images/default_avatar.jpg',

        // Socialite
        'socialite' => [
            // Github登录
            'github' => [
                'app' => 'github',
                'name' => 'Github',
                'icon' => '<i class="fa fa-github" aria-hidden="true"></i>',
                'enabled' => 0,
            ],
            // QQ登录
            'qq' => [
                'app' => 'qq',
                'name' => 'QQ',
                'icon' => '<i class="fa fa-qq" aria-hidden="true"></i>',
                'enabled' => 0,
            ],
            // 微信登录
            'weixinweb' => [
                'app' => 'weixinweb',
                'name' => 'Wechat',
                'icon' => '<i class="fa fa-weixin" aria-hidden="true"></i>',
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
            'effective_days' => 0,
            // 邀请余额是否可以支付
            'invite_balance_can_pay' => 1,
        ],
    ],

    // 上传
    'upload' => [
        'image' => [
            'disk' => 'public',
            'path' => 'images',
            'params' => '',
        ],
        'video' => [
            'aliyun' => [
                'region' => 'cn-shanghai',
                'access_key_id' => '',
                'access_key_secret' => '',
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
            'handler' => \App\Meedu\Payment\Alipay\Alipay::class,
            'name' => '支付宝',
            'sign' => 'alipay',
            'default_method' => 'web',
            'pc' => 'web',
            'h5' => 'wap',
            'enabled' => 0,
        ],
        'wechat' => [
            'handler' => \App\Meedu\Payment\Wechat\Wechat::class,
            'name' => '微信支付',
            'sign' => 'wechat',
            'default_method' => 'scan',
            'pc' => 'scan',
            'h5' => 'wap',
            'wechat' => 'mp',
            'enabled' => 0,
        ],
        'handPay' => [
            'handler' => \App\Meedu\Payment\HandPay\HandPay::class,
            'name' => '手动打款',
            'sign' => 'handPay',
            'default_method' => 'hand',
            'pc' => 'hand',
            'h5' => 'hand',
            'wechat' => 'hand',
            'enabled' => 0,
            'introduction' => '',
        ],
    ],

    // SEO
    'seo' => [
        'index' => [
            'title' => 'MeEdu',
            'keywords' => '',
            'description' => 'MeEdu是一套开源的，免费的在线视频点播系统。',
        ],
        'course_list' => [
            'title' => '所有课程',
            'keywords' => '',
            'description' => 'MeEdu是一套开源的，免费的在线视频点播系统。',
        ],
        'role_list' => [
            'title' => 'VIP',
            'keywords' => '',
            'description' => 'MeEdu是一套开源的，免费的在线视频点播系统。',
        ],
    ],

    // 系统配置
    'system' => [
        'icp' => '',
        'logo' => '/frontend/logo.png',
        // 缓存开关
        'cache' => [
            'status' => -1,
            'expire' => 360,
        ],
        // 短信频率
        'limiter' => [
            'sms' => [
                'times' => 1,
                'minutes' => 1,
            ]
        ],
        // 测试手机号
        'test' => explode(',', env('TEST_MOBILE', '')),
        // 统计代码
        'js' => '',
        // 主题
        'theme' => [
            'use' => 'default',
            'path' => resource_path('views'),
        ],
        'sms' => 'yunpian',
        // 备份开关
        'backup' => 0,
        // editor
        'editor' => \App\Constant\FrontendConstant::RENDER_MARKDOWN,
    ],

    // 视频鉴权
    'video' => [
        'auth' => [
            'aliyun' => [
                'private_key' => env('ALIYUN_VIDEO_AUTH_PRIVATE_KEY', ''),
            ],
        ],
    ],

    // 其它配置
    'other' => [
        // 课程列表页展示条数
        'course_list_page_size' => 6,
        // 视频列表页展示条数
        'video_list_page_size' => 15,
    ],
];