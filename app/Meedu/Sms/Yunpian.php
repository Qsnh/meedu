<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Sms;

use GuzzleHttp\Client;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class Yunpian implements SmsInterface
{
    /**
     * @param string $mobile
     * @param $code
     * @param $template
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendCode(string $mobile, $code, $template)
    {
        /**
         * @var ConfigService $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);
        $key = $configService->getSms()['gateways']['yunpian']['api_key'] ?? '';

        $http = new Client(['timeout' => 5.0]);
        $response = $http->post('https://sms.yunpian.com/v2/sms/single_send.json', [
            'form_params' => [
                'apikey' => $key,
                'mobile' => $mobile,
                'text' => str_replace('#code#', $code, $template),
            ],
        ]);
        if ($response->getStatusCode() !== 200) {
            throw new \Exception('云片短信请求失败');
        }
        $body = json_decode($response->getBody()->getContents(), true);
        $responseCode = $body['code'] ?? false;
        if ($responseCode !== 0) {
            throw new \Exception($body['msg'] ?? json_encode($body));
        }
    }
}
