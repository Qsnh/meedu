<?php
/**
 * Created by PhpStorm.
 * User: xiaoteng
 * Date: 2019/2/28
 * Time: 19:27
 */

return [
    'vod' => [
        'app_id' => '',
        'secret_id' => '',
        'secret_key' => '',
    ],
    'wechat' => [
        'mini' => [
            'app_id' => env('WECHAT_MINI_APP_ID', ''),
            'secret' => env('WECHAT_MINI_APP_SECRET', ''),
        ],
    ],
];