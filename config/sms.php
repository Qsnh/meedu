<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

return [
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
            'signature' => '',
            'template' => [
                'password_reset' => '',
                'register' => '',
                'mobile_bind' => '',
                'login' => '',
            ],
        ],
    ],
];
