<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use App\Bus\WechatScanBusV2;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V2\BaseController;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class WechatScanLoginController extends BaseController
{
    public function index(ConfigServiceInterface $configService, Request $request, WechatScanBusV2 $bus)
    {
        if ($request->has('login_err_msg')) {
            // 登录失败
            $msg = $request->get('login_err_msg');
            return view('wechat_scan_login.fail', compact('msg'));
        }

        if ($request->has('login_code')) {
            // 登录成功
            $loginCode = $request->get('login_code');
            $key = $request->get('wechat_scan_key');
            if (!$loginCode || !$key || !$bus->isValid($key)) {
                return view('wechat_scan_login.fail', ['msg' => '参数错误']);
            }
            $bus->setCode($key, $loginCode);
            // 网站名
            $appName = $configService->appName();
            return view('wechat_scan_login.success', compact('appName'));
        }

        $key = $request->input('key');
        $action = $request->input('action');
        if (!$key || !$action || !in_array($action, ['login', 'bind'])) {
            return $this->error(__('参数错误'));
        }

        $url = route('api.v3.wechat-scan-login.page') . '?' . http_build_query(['wechat_scan_key' => $key]);

        // 登录地址
        $loginUrl = route('api.v3.login.wechat-oauth') . '?' . http_build_query(['s_url' => $url, 'f_url' => $url, 'action' => $action]);
        // 网站名
        $appName = $configService->appName();

        return view('wechat_scan_login.index', compact('appName', 'loginUrl'));
    }

    public function getLoginUrl(WechatScanBusV2 $bus)
    {
        return $this->data($bus->getLoginUrl());
    }

    public function query(Request $request, WechatScanBusV2 $bus)
    {
        $key = $request->input('key');
        if (!$key) {
            return $this->error(__('参数错误'));
        }

        if ($bus->isValid($key)) {
            return $this->error(__('参数错误'));
        }

        $code = $bus->code($key);

        return $this->data(['code' => $code]);
    }
}
