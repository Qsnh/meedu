<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Sms;

use App\Services\Base\Interfaces\ConfigServiceInterface;

class Aliyun implements SmsInterface
{
    public function sendCode(string $mobile, $code, $template)
    {
        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);
        $config = $configService->getSms()['gateways']['aliyun'];

        \AlibabaCloud\Client\AlibabaCloud::accessKeyClient($config['access_key_id'], $config['access_key_secret'])
            ->regionId('cn-hangzhou')
            ->timeout(5)
            ->asDefaultClient();

        $result = \AlibabaCloud\Client\AlibabaCloud::rpc()
            ->product('Dysmsapi')
            ->version('2017-05-25')
            ->action('SendSms')
            ->method('POST')
            ->host('dysmsapi.aliyuncs.com')
            ->options([
                'query' => [
                    'PhoneNumbers' => $mobile,
                    'SignName' => $config['sign_name'],
                    'TemplateCode' => $template,
                    'TemplateParam' => json_encode([
                        'code' => $code,
                    ]),
                ],
            ])
            ->request();

        $responseCode = $result['Code'];
        $responseMessage = $result['Message'];
        if (!($responseCode === 'OK' && $responseMessage === 'OK')) {
            throw new \Exception($responseMessage);
        }
    }
}
