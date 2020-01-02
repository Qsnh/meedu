<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Services\Other\Services\SmsService;
use App\Http\Requests\Frontend\SmsSendRequest;
use App\Services\Other\Interfaces\SmsServiceInterface;

class SmsController extends FrontendController
{
    /**
     * @var SmsService
     */
    protected $smsService;

    public function __construct(SmsServiceInterface $smsService)
    {
        $this->smsService = $smsService;
    }

    public function send(SmsSendRequest $request)
    {
        $data = $request->filldata();
        $method = 'send'.$data['method'];
        try {
            return $this->{$method}($data['mobile']);
        } catch (Exception $exception) {
            exception_record($exception);

            return exception_response($exception, __('error'));
        }
    }

    public function sendRegister($mobile)
    {
        return $this->sendHandler($mobile, 'sms_register', 'register');
    }

    public function sendPasswordReset($mobile)
    {
        return $this->sendHandler($mobile, 'sms_password_reset', 'password_reset');
    }

    public function sendMobileBind($mobile)
    {
        return $this->sendHandler($mobile, 'sms_mobile_bind', 'mobile_bind');
    }

    /**
     * @param $mobile
     * @param $sessionKey
     * @param $templateId
     *
     * @return array
     *
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
     */
    protected function sendHandler($mobile, $sessionKey, $templateId)
    {
        $code = mt_rand(1000, 10000);
        session([$sessionKey => $code]);

        $this->smsService->sendCode($mobile, $code, $templateId);

        return $this->success(__('success'));
    }
}
