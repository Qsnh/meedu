<?php

return [
    'default' => [
        'gateways' => [
            'aliyun',
        ],
    ],
    'gateways' => [
        'aliyun' => [
            'access_key_id' => env('ALIYUN_ACCESS_KEY_ID', ''),
            'access_key_secret' => env('ALIYUN_ACCESS_KEY_SECRET', ''),
            'sign_name' => '微菲系统',
            'template' => [
                'password_reset' => 'SMS_81985082',
                'register' => 'SMS_81985082',
            ],
        ],
    ],
];