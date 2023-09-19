<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Services;

use Illuminate\Support\Str;
use App\Meedu\Sms\SmsInterface;
use App\Services\Other\Models\SmsRecord;
use App\Services\Other\Interfaces\SmsServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class SmsService implements SmsServiceInterface
{
    private $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    public function sendCode($mobile, $code, $scene): void
    {
        $sceneMethod = sprintf('get%sSceneTemplateId', Str::camel($scene));
        $templateId = $this->$sceneMethod();

        /**
         * @var SmsInterface $smsHandler
         */
        $smsHandler = app()->make(SmsInterface::class);

        $smsHandler->sendCode($mobile, $code, $templateId);

        SmsRecord::createData($mobile, compact('code'), []);
    }

    private function getLoginSceneTemplateId()
    {
        return $this->configService->getLoginSmsTemplateId();
    }

    private function getRegisterSceneTemplateId()
    {
        return $this->configService->getRegisterSmsTemplateId();
    }

    private function getPasswordResetSceneTemplateId()
    {
        return $this->configService->getPasswordResetSmsTemplateId();
    }

    private function getMobileBindSceneTemplateId()
    {
        return $this->configService->getMobileBindSmsTemplateId();
    }
}
