<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

return [
    'alipay' => [
        // 支付宝分配的 APPID
        'app_id' => env('ALIPAY_APP_ID', ''),

        // 支付宝异步通知地址
        'notify_url' => env('ALIPAY_NOTIFY_URL', ''),

        // 支付成功后同步通知地址
        'return_url' => env('ALIPAY_RETURN_URL', ''),

        // 支付宝公钥
        'ali_public_key' => env('ALIPAY_PUBLIC_KEY', ''),

        // 自己的私钥，签名时使用 - 使用证书签名，该参数用不到
        'private_key' => env('ALIPAY_APP_PRIVATE_KEY', ''),

        // 应用公钥证书-必须是路径
        'app_cert_public_key' => env('ALIPAY_APP_CERT_PUBLIC_KEY_PATH', ''),

        // 支付宝根证书-必须是路径
        'alipay_root_cert' => env('ALIPAY_ROOT_CERT_PATH', ''),

        // optional，默认 warning；日志路径为：().'/logssys_get_temp_dir/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/alipay.log'),
            'level' => 'debug',
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30,
        ],

        // optional，设置此参数，将进入沙箱模式
        // 'mode' => 'dev',
    ],

    'wechat' => [
        // 公众号 APPID
        'app_id' => env('WECHAT_PAY_APP_ID', ''),

        // 小程序 APPID
        'miniapp_id' => env('WECHAT_PAY_MINIAPP_ID', ''),

        // APP 引用的 appid
        'appid' => env('WECHAT_PAY_APPID', ''),

        // 微信支付分配的微信商户号
        'mch_id' => env('WECHAT_PAY_MCH_ID', ''),

        // 微信支付签名秘钥
        'key' => env('WECHAT_PAY_KEY', ''),

        // 微信支付异步通知地址
        'notify_url' => env('WECHAT_PAY_NOTIFY_URL', ''),

        // 客户端证书路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_client' => env('WECHAT_PAY_CERT_CLIENT_PATH', ''),

        // 客户端秘钥路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_key' => env('WECHAT_PAY_CERT_KEY_PATH', ''),

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/wechat.log'),
            'level' => 'debug',
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30,
        ],

        // optional
        // 'dev' 时为沙箱模式
        // 'hk' 时为东南亚节点
        // 'mode' => 'dev',
    ],
];
