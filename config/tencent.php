<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

return [
    'vod' => [
        'app_id' => '',
        'secret_id' => '',
        'secret_key' => '',
        'transcode_format' => env('TENCENT_VOD_TRANSCODE_FORMAT', 'm3u8'),
    ],
    'wechat' => [
        'mini' => [
            'app_id' => env('WECHAT_MINI_APP_ID', ''),
            'secret' => env('WECHAT_MINI_APP_SECRET', ''),
        ],
    ],
];
