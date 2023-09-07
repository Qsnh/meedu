<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Proxies;

use App\Meedu\ServiceProxy\ServiceProxy;
use App\Services\Other\Services\SmsService;
use App\Meedu\ServiceProxy\Limiter\LimiterInfo;
use App\Services\Other\Interfaces\SmsServiceInterface;

class SmsServiceProxy extends ServiceProxy implements SmsServiceInterface
{
    public function __construct(SmsService $service)
    {
        parent::__construct($service);
        //        $this->limit['sendCode'] = function ($mobile, $code, $templateId) {
        //            ['times' => $times, 'minutes' => $minutes] = $this->configService->getSmsLimiter();
        //
        //            return new LimiterInfo('os:sms:'.$mobile, $times, $minutes);
        //        };
    }
}
