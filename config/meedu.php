<?php

return [

    'save' => storage_path('/meedu_config.json'),

    // 会员配置
    'member' => [
        'is_active_default' => \App\User::ACTIVE_NO,
        'is_lock_default' => \App\User::LOCK_NO,

        // 头像
        'default_avatar' => '/images/default_avatar.jpg',
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
        ],
    ],

    // 管理员配置
    'administrator' => [
        'super_slug' => 'administrator',
    ],
    
    // 支付网关
    'payment' => [
        'youzan' => [
            'client_id' => env('YOUZAN_CLIENT_ID', ''),
            'client_secret' => env('YOUZAN_CLIENT_SECRET', ''),
            'kdt_id' => env('YOUZAN_CLIENT_KDT_ID', ''),
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
        'cache' => [
            'status' => 0,
            'expire' => 360,
        ],
    ],
];