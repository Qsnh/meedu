<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Meedu\Tencent\WechatMp;
use App\Http\Controllers\Api\V2\BaseController;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class OtherController extends BaseController
{
    /**
     * @api {GET} /api/v3/other/wechat-mp-jssdk [V3]微信公众号JSSDK签名
     * @apiGroup 其它模块
     * @apiName OtherV3
     *
     * @apiParam {String} path 前端页面完整URL
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number=0,1} data.enabled 是否开启{0:否,1:是}
     * @apiSuccess {Object} data.data
     * @apiSuccess {String} data.data.appId appId
     * @apiSuccess {String} data.data.nonceStr nonceStr
     * @apiSuccess {String} data.data.timestamp timestamp
     * @apiSuccess {String} data.data.signature signature
     * @apiSuccess {String} data.data.jsApiList jsApiList
     * @apiSuccess {String} data.data.debug debug
     * @apiSuccess {String} data.data.beta beta
     * @apiSuccess {String} data.data.openTagList openTagList
     * @apiSuccess {Object} data.share
     * @apiSuccess {String} data.share.title 首页分享标题
     * @apiSuccess {String} data.share.desc 首页分享描述
     * @apiSuccess {String} data.share.icon 首页分享图标
     */
    public function wechatMpJSSDK(Request $request, WechatMp $wechatMp, ConfigServiceInterface $configService)
    {
        $url = $request->input('path');
        if (!$url) {
            return $this->error(__('参数错误'));
        }

        $mpConfig = $configService->getWechatMpConfig();
        if (1 !== (int)$mpConfig['share']['enabled']) {
            return $this->data(['enabled' => 0]);
        }

        $data = $wechatMp->buildJsConfig(
            $url,
            [
                'updateAppMessageShareData',
                'updateTimelineShareData',
                'chooseImage',
                'previewImage',
                'uploadImage',
                'downloadImage',
                'getLocalImgData',
            ],
            false,
            false,
            false,
            [
                'wx-open-launch-weapp',
                'wx-open-subscribe',
                'wx-open-launch-app',
                'wx-open-audio',
            ]
        );

        return $this->data([
            'enabled' => 1,
            'data' => $data,
            'share' => [
                'title' => $mpConfig['share']['title'] ?? '',
                'desc' => $mpConfig['share']['desc'] ?? '',
                'icon' => $mpConfig['share']['imgUrl'] ?? '',
            ],
        ]);
    }

}
