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

use App\Models\SmsRecord;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Frontend\SmsSendRequest;

class SmsController extends FrontendController
{
    public function send(SmsSendRequest $request)
    {
        $data = $request->filldata();
        $method = 'send'.$data['method'];

        return $this->{$method}($request, $data['mobile']);
    }

    public function sendPasswordReset($request, $mobile)
    {
        $code = mt_rand(1000, 10000);

        session(['password_reset_captcha' => $code]);

        $config = config('sms');
        $easySms = new EasySms($config);

        try {
            $data = [
                'content' => "您的验证码为：{$code}",
                'template' => $config['gateways'][$config['default']['gateways'][0]]['template']['password_reset'],
                'data' => [
                    'code' => $code,
                ],
            ];
            $sendResponse = $easySms->send($mobile, $data);

            // Log
            SmsRecord::createData($mobile, $data, $sendResponse);

            return $this->success('验证码发送成功');
        } catch (\Exception $exception) {
            return exception_response($exception, '验证码发送失败');
        }
    }
}
