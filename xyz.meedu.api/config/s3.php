<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

return [
    'public' => [
        'key_id' => '',
        'key_secret' => '',
        'region' => '',
        'bucket' => '',
        'endpoint' => [
            'internal' => '',
            'external' => '',
        ],
        'cdn' => [
            'domain' => '',
        ],
        'use_path_style_endpoint' => env('S3_PUBLIC_USE_PATH_STYLE_ENDPOINT', false),
    ],
    'private' => [
        'key_id' => '',
        'key_secret' => '',
        'region' => '',
        'bucket' => '',
        'endpoint' => [
            'internal' => '',
            'external' => '',
        ],
        'use_path_style_endpoint' => env('S3_PRIVATE_USE_PATH_STYLE_ENDPOINT', false),
    ],
];
