<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Other\Services;

use Overtrue\EasySms\EasySms;
use App\Services\Other\Models\SmsRecord;
use App\Services\Other\Interfaces\SmsServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class SmsService implements SmsServiceInterface
{
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param $mobile
     * @param $code
     * @param $templateId
     *
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
     */
    public function sendCode($mobile, $code, $templateId): void
    {
        $config = $this->configService->getSms();
        $easySms = new EasySms($config);
        $data = [
            'content' => str_replace('#code#', $code, $config['gateways'][$config['default']['gateways'][0]]['template'][$templateId]),
            'template' => $config['gateways'][$config['default']['gateways'][0]]['template'][$templateId],
            'data' => ['code' => $code],
        ];
        $sendResponse = $easySms->send($mobile, $data);

        SmsRecord::createData($mobile, $data, $sendResponse);
    }
}
