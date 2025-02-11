<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeV4917
{

    public static function handle()
    {
        self::deleteSomeConfigItems();
        self::smsConfigRename();
    }

    private static function deleteSomeConfigItems()
    {
        AppConfig::query()
            ->whereIn('key', [
                'meedu.mp_wechat.aes_key',
                'meedu.mp_wechat.enabled_share',
                'meedu.meeducloud.domain',
                'meedu.meeducloud.user_id',
                'meedu.meeducloud.password',
            ])
            ->delete();
    }

    private static function smsConfigRename()
    {
        $config = [
            'sms.gateways.aliyun.access_key_id' => 'AccessKeyId',
            'sms.gateways.aliyun.access_key_secret' => 'AccessKeySecret',
            'sms.gateways.aliyun.sign_name' => '短信签名',
            'sms.gateways.aliyun.template.password_reset' => '密码重置模板ID',
            'sms.gateways.aliyun.template.register' => '注册模板ID',
            'sms.gateways.aliyun.template.mobile_bind' => '手机号绑定模板ID',
            'sms.gateways.aliyun.template.login' => '手机号登录模板ID',
            'sms.gateways.tencent.sdk_app_id' => 'SdkAppId',
            'sms.gateways.tencent.region' => 'Region',
            'sms.gateways.tencent.secret_id' => 'SecretId',
            'sms.gateways.tencent.secret_key' => 'SecretKey',
            'sms.gateways.tencent.sign_name' => 'SignName',
            'sms.gateways.tencent.template.password_reset' => '密码重置模板ID',
            'sms.gateways.tencent.template.register' => '注册模板ID',
            'sms.gateways.tencent.template.mobile_bind' => '手机号绑定模板ID',
            'sms.gateways.tencent.template.login' => '手机号登录模板ID',
        ];

        foreach ($config as $keyName => $displayName) {
            AppConfig::query()->where('key', $keyName)->update(['name' => $displayName]);
        }
    }

}
