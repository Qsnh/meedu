<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class ServerController extends Controller
{
    public function index(Request $request, ConfigServiceInterface $configService)
    {
        if ($request->isMethod('get')) {
            $signature = $request->input('signature');
            $timestamp = $request->input('timestamp');
            $nonce = $request->input('nonce');
            $echostr = $request->input('echostr');

            $mpConfig = $configService->getWechatMpConfig();
            $token = $mpConfig['token'];

            // 按照微信的规则进行签名验证
            $tmpArr = [$token, $timestamp, $nonce];
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode($tmpArr);
            $tmpStr = sha1($tmpStr);

            if ($tmpStr === $signature) {
                return $echostr;
            }
            return 'fail';
        }
        return 'success';
    }
}
