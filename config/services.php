<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID', ''),
        'client_secret' => env('GITHUB_CLIENT_SECRET', ''),
        'redirect' => env('GITHUB_CALLBACK_URL', ''),
    ],

    'qq' => [
        'client_id' => env('QQ_KEY'),
        'client_secret' => env('QQ_SECRET'),
        'redirect' => env('QQ_CALLBACK_URL')
    ],

    'weixinweb' => [
        'client_id' => env('WEIXINWEB_KEY'),
        'client_secret' => env('WEIXINWEB_SECRET'),
        'redirect' => env('WEIXINWEB_REDIRECT_URI')
    ],

];
