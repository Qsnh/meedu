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

        $key = $request->get('key');
        $action = $request->get('action');
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

    /**
     * @api {post} /api/v3/auth/login/wechat-scan/url [V3]获取微信扫码[登录|绑定]的URL
     * @apiGroup 用户认证
     * @apiName WechatScanUrlV3
     *
     * @apiParam {String=bind:绑定,login:登录} action 搜索关键字
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {String} data.url URL值
     * @apiSuccess {String} data.key 随机码(用于查询登录结果)
     * @apiSuccess {Number} data.expire 到期的时间戳(到期需要重新获取URL)
     */
    public function getLoginUrl(Request $request, WechatScanBusV2 $bus)
    {
        $action = $request->get('action');
        if (!$action || !in_array($action, ['bind', 'login'])) {
            return $this->error(__('参数错误'));
        }

        return $this->data($bus->getLoginUrl($action));
    }

    /**
     * @api {get} /api/v3/auth/login/wechat-scan/query [V3]微信扫码[登录|绑定]结果查询
     * @apiGroup 用户认证
     * @apiName WechatScanQueryV3
     *
     * @apiParam {String} key 随机码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Object} data.code 登录码
     */
    public function query(Request $request, WechatScanBusV2 $bus)
    {
        $key = $request->input('key');
        if (!$key || !$bus->isValid($key)) {
            return $this->error(__('参数错误'));
        }

        $code = $bus->code($key);

        return $this->data(['code' => $code]);
    }
}
