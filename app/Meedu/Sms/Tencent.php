<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Sms;

use TencentCloud\Common\Credential;
use TencentCloud\Sms\V20210111\SmsClient;
use TencentCloud\Common\Profile\HttpProfile;
use App\Services\Base\Services\ConfigService;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Sms\V20210111\Models\SendSmsRequest;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class Tencent implements SmsInterface
{
    public function sendCode(string $mobile, $code, $template)
    {
        /**
         * @var ConfigService $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);
        $config = $configService->getTencentSms();

        $cred = new Credential($config['secret_id'], $config['secret_key']);
        $httpProfile = new HttpProfile();
        $httpProfile->setEndpoint('sms.tencentcloudapi.com');

        $clientProfile = new ClientProfile();
        $clientProfile->setHttpProfile($httpProfile);
        $client = new SmsClient($cred, $config['region'], $clientProfile);

        $req = new SendSmsRequest();

        $params = [
            'PhoneNumberSet' => [$mobile],
            'SmsSdkAppId' => $config['sdk_app_id'],
            'SignName' => $config['sign_name'],
            'TemplateId' => $template,
            'TemplateParamSet' => [$code],
        ];
        $req->fromJsonString(json_encode($params));

        $client->SendSms($req);
    }
}
