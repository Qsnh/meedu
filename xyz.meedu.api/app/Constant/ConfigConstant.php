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

    public const APP_URL ='app.url';

    public const TENCENT_VOD_APP_ID='tencent.vod.app_id';
    public const TENCENT_VOD_SECRET_ID = 'tencent.vod.secret_id';
    public const TENCENT_VOD_SECRET_KEY='tencent.vod.secret_key';
    public const TENCENT_VOD_CALLBACK_KEY='tencent.vod.callback_key';
    public const TENCENT_VOD_PLAY_KEY= 'meedu.system.player.tencent_play_key';

    public const ALIYUN_VOD_ACCESS_KEY_ID = 'meedu.upload.video.aliyun.access_key_id';
    public const ALIYUN_VOD_ACCESS_KEY_SECRET = 'meedu.upload.video.aliyun.access_key_secret';
    public const ALIYUN_VOD_REGION = 'meedu.upload.video.aliyun.region';
    public const ALIYUN_VOD_HOST = 'meedu.upload.video.aliyun.host';
    public const ALIYUN_VOD_CALLBACK_KEY = 'meedu.upload.video.aliyun.callback_key';
}
