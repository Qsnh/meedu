<?php

return [
    'default' => [
        'gateways' => [
            'yunpian',
        ],
    ],
    'gateways' => [
        'aliyun' => [
            'access_key_id' => env('ALIYUN_ACCESS_KEY_ID', ''),
            'access_key_secret' => env('ALIYUN_ACCESS_KEY_SECRET', ''),
            'sign_name' => '',
            'template' => [
                'password_reset' => '',
                'register' => '',
                'mobile_bind' => '',
                'login' => '',
            ],
        ],
        'yunpian' => [
            'api_key' => env('SMS_YUNPIAN_API_KEY', ''),
            'signature' => '【默认签名】',
            'template' => [
                'password_reset' => '',
                'register' => '',
                'mobile_bind' => '',
                'login' => '',
            ],
        ],
    ],
];