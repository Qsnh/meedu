<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'attach' => [
            'driver' => 'local',
            'root' => storage_path('app/attach'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'oss' => [
            'driver' => 'oss',
            'access_id' => env('ALI_OSS_ACCESS_ID'),
            'access_key' => env('ALI_OSS_ACCESS_KEY'),
            'bucket' => env('ALI_OSS_BUCKET'),
            'endpoint' => env('ALI_OSS_ENDPOINT'),
            'cdnDomain' => env('ALI_OSS_DOMAIN'),
            'ssl' => true,
            'isCName' => true,
            'debug' => false,
        ],

        'cos' => [
            'driver' => 'cos',
            'region' => env('TENCENT_COS_REGION', 'ap-guangzhou'),
            'credentials' => [
                'appId' => env('TENCENT_COS_APP_ID'),
                'secretId' => env('TENCENT_COS_SECRET_ID'),
                'secretKey' => env('TENCENT_COS_SECRET_KEY'),
            ],
            'timeout' => 60,
            'connect_timeout' => 5,
            'bucket' => env('TENCENT_COS_BUCKET'),
            'cdn' => env('TENCENT_COS_CDN'),
            'scheme' => 'https',
            'read_from_cdn' => env('TENCENT_COS_READ_FROM_CDN', false),
        ],

    ],

];
