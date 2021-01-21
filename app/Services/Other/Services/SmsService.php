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

use Illuminate\Support\Str;
use App\Meedu\Sms\SmsInterface;
use App\Services\Other\Models\SmsRecord;
use App\Services\Base\Services\ConfigService;
use App\Services\Other\Interfaces\SmsServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class SmsService implements SmsServiceInterface
{
    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param $mobile
     * @param $code
     * @param $scene
     */
    public function sendCode($mobile, $code, $scene): void
    {
        $sceneMethod = sprintf('get%sSceneTemplateId', Str::camel($scene));
        $templateId = $this->$sceneMethod();

        /**
         * @var SmsInterface $sms
         */
        $sms = app()->make(SmsInterface::class);
        $sms->sendCode($mobile, $code, $templateId);

        SmsRecord::createData($mobile, compact('code'), []);
    }

    protected function getLoginSceneTemplateId()
    {
        return $this->configService->getLoginSmsTemplateId();
    }

    protected function getRegisterSceneTemplateId()
    {
        return $this->configService->getRegisterSmsTemplateId();
    }

    protected function getPasswordResetSceneTemplateId()
    {
        return $this->configService->getPasswordResetSmsTemplateId();
    }

    protected function getMobileBindSceneTemplateId()
    {
        return $this->configService->getMobileBindSmsTemplateId();
    }
}
