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

    public const APP_URL = 'app.url';

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
}
