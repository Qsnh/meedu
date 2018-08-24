<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\SmsSendRequest;
use App\Models\SmsRecord;
use Overtrue\EasySms\EasySms;

class SmsController extends BaseController
{

    public function send(SmsSendRequest $request)
    {
        $data = $request->filldata();
        $method = 'send' . $data['method'];
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
