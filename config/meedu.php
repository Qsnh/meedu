<?php

return [

    'save' => storage_path('/meedu_config.json'),

    // 会员配置
    'member' => [
        'is_active_default' => \App\User::ACTIVE_NO,
        'is_lock_default' => \App\User::LOCK_NO,

        // 头像
        'default_avatar' => '/images/default_avatar.jpg',

        // Socialite
        'socialite' => [
            [
                'app' => 'github',
                'name' => 'Github',
                'icon' => '<i class="fa fa-github" aria-hidden="true"></i>',
                'enabled' => false,
            ],
        ],
    ],

    // 系统结算
    'credit' => [
        'credit1' => [
            'name' => '余额',
            'use' => true,
        ],
        'credit2' => [
            'name' => '积分',
            'use' => true,
        ],
        'credit3' => [
            'name' => '金币',
            'use' => true,
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
            'pc' => true,
            'enabled' => 1,
        ],
        'wechat' => [
            'handler' => \App\Meedu\Payment\Wechat\Wechat::class,
            'name' => '微信支付',
            'sign' => 'wechat',
            'default_method' => 'scan',
            'pc' => true,
            'enabled' => 1,
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
        'book_list' => [
            'title' => '电子书',
            'keywords' => '',
            'description' => 'MeEdu是一套开源的，免费的在线视频点播系统。',
        ],
    ],

    // 系统配置
    'system' => [
        'cache' => [
            'status' => -1,
            'expire' => 360,
        ],
        'indexMenu' => [
            'course' => env('INDEX_MENU_COURSE_SHOW', true),
            'book' => env('INDEX_MENU_BOOK_SHOW', true),
            'faq' => env('INDEX_MENU_FAQ_SHOW', true),
            'vip' => env('INDEX_MENU_VIP_SHOW', true),
        ],
        'test' => explode(',', env('TEST_MOBILE', '')),
        'js' => '',
        'theme' => [
            'use' => 'default',
            'path' => resource_path('views'),
        ],
        'sms' => 'yunpian',
    ],

    // 视频鉴权
    'video' => [
        'auth' => [
            'aliyun' => [
                'private_key' => env('ALIYUN_VIDEO_AUTH_PRIVATE_KEY', ''),
            ],
        ],
    ],

    // advance
    'advance' => [
        'layout_footer' => env('LAYOUT_FOOTER') ?: 'components.frontend.footer',
        'template_index' => env('TEMPLATE_INDEX') ?: 'frontend.index.index',
    ],

    // MeEduCloud
    'cloud' => [
        'client_id' => 2,
        'client_secret' => 'MUe00r1VZ5PnT3R5vR3Em3W343YEzmAdrB48ZgYG',
        'username' => env('MEEDU_CLOUD_USERNAME', ''),
        'password' => env('MEEDU_CLOUD_PASSWORD', ''),
    ],
];