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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
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
        $method = 'send' . Str::camel($data['method']);
        try {
            return $this->{$method}($data['mobile']);
        } catch (Exception $exception) {
            exception_record($exception);

            return $this->error(__('error'));
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

    public function sendMobileLogin($mobile)
    {
        return $this->sendHandler($mobile, 'sms_mobile_login', 'login');
    }

    /**
     * @param $mobile
     * @param $sessionKey
     * @param $templateId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
     */
    protected function sendHandler($mobile, $sessionKey, $templateId)
    {
        $code = sprintf('%06d', random_int(1, 999999));
        session([$sessionKey => $code]);

        if (is_dev()) {
            // 开发环境直接跳过
            Log::info(__METHOD__, ['code' => $code]);
            return $this->success();
        }

        $this->smsService->sendCode($mobile, $code, $templateId);

        return $this->success();
    }
}
