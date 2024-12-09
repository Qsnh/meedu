<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Constant;

class ConfigConstant
{
    public const PRIVATE_MASK = '************';

    public const TENCENT_VOD_PREFIX = 'tencent.vod.';
    public const TENCENT_VOD_APP_ID = self::TENCENT_VOD_PREFIX . 'app_id';
    public const TENCENT_VOD_SECRET_ID = self::TENCENT_VOD_PREFIX . 'secret_id';
    public const TENCENT_VOD_SECRET_KEY = self::TENCENT_VOD_PREFIX . 'secret_key';
    public const TENCENT_VOD_CALLBACK_KEY = self::TENCENT_VOD_PREFIX . 'callback_key';
    public const TENCENT_VOD_PLAY_KEY = self::TENCENT_VOD_PREFIX . 'play_key';
    public const TENCENT_VOD_PLAY_DOMAIN = self::TENCENT_VOD_PREFIX . 'play_domain';

    public const ALIYUN_VOD_PREFIX = 'meedu.upload.video.aliyun.';
    public const ALIYUN_VOD_ACCESS_KEY_ID = self::ALIYUN_VOD_PREFIX . 'access_key_id';
    public const ALIYUN_VOD_ACCESS_KEY_SECRET = self::ALIYUN_VOD_PREFIX . 'access_key_secret';
    public const ALIYUN_VOD_REGION = self::ALIYUN_VOD_PREFIX . 'region';
    public const ALIYUN_VOD_HOST = self::ALIYUN_VOD_PREFIX . 'host';
    public const ALIYUN_VOD_CALLBACK_KEY = self::ALIYUN_VOD_PREFIX . 'callback_key';
    public const ALIYUN_VOD_PLAY_DOMAIN = self::ALIYUN_VOD_PREFIX . 'play_domain';
    public const ALIYUN_VOD_PLAY_KEY = self::ALIYUN_VOD_PREFIX . 'play_key';

    public const S3_CONFIG_OVERRIDE = [
        'filesystems.disks.s3-public.key' => 's3.public.key_id',
        'filesystems.disks.s3-public.secret' => 's3.public.key_secret',
        'filesystems.disks.s3-public.region' => 's3.public.region',
        'filesystems.disks.s3-public.bucket' => 's3.public.bucket',
        'filesystems.disks.s3-public.endpoint' => 's3.public.endpoint.internal',

        'filesystems.disks.s3-private.key' => 's3.private.key_id',
        'filesystems.disks.s3-private.secret' => 's3.private.key_secret',
        'filesystems.disks.s3-private.region' => 's3.private.region',
        'filesystems.disks.s3-private.bucket' => 's3.private.bucket',
        'filesystems.disks.s3-private.endpoint' => 's3.private.endpoint.internal',
    ];
}
