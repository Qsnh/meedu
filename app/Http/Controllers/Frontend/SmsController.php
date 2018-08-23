<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\SmsSendRequest;
use Illuminate\Support\Facades\Session;
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
        $code = sprintf("%4d", mt_rand(0, 10000));

        Session::set(['password_reset_captcha' => $code]);

        $config = config('sms');
        $easySms = new EasySms($config);
        $sendResponse = $easySms->send($mobile, [
            'content' => "您的验证码为：{$code}",
            'template' => $config['gateways'][$config['default']['gateways'][0]]['template']['password_reset'],
            'data' => [
                'code' => $code,
            ],
        ]);

        \Log::info($sendResponse);

        return $this->success('验证码发送成功');
    }



}
