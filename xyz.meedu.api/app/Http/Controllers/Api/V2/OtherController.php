<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Meedu\Addons;
use App\Meedu\Hooks\HookRun;
use App\Constant\HookConstant;
use App\Constant\FrontendConstant;
use App\Meedu\Cache\Impl\NavCache;
use App\Meedu\Cache\Impl\LinkCache;
use App\Meedu\Cache\Impl\SliderCache;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class OtherController extends BaseController
{
    /**
     * @api {get} /api/v2/other/config [V2]应用配置
     * @apiGroup 系统模块
     * @apiName OtherSystemConfig
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.webname 网站名
     * @apiSuccess {String} data.url 网站地址
     * @apiSuccess {String} data.pc_url PC网站地址
     * @apiSuccess {String} data.h5_url H5网站地址
     * @apiSuccess {String} data.icp ICP备案号
     * @apiSuccess {String} data.user_protocol 用户协议URL
     * @apiSuccess {String} data.user_private_protocol 用户隐私协议URL
     * @apiSuccess {String} data.paid_content_purchase_protocol 付费内容购买协议URL
     * @apiSuccess {String} data.aboutus 关于我们
     * @apiSuccess {String} data.logo LOGO的URL
     * @apiSuccess {Object} data.player 播放器
     * @apiSuccess {String} data.player.cover 播放器封面
     * @apiSuccess {Number} data.player.enabled_bullet_secret 开启跑马灯[1:是,0否]
     * @apiSuccess {Object} data.player.bullet_secret 跑马灯配置
     * @apiSuccess {String} data.player.bullet_secret.text 跑马灯-内容
     * @apiSuccess {String} data.player.bullet_secret.color 跑马灯-颜色
     * @apiSuccess {String} data.player.bullet_secret.opacity 跑马灯-透明度
     * @apiSuccess {Number} data.player.bullet_secret.size 跑马灯—文字大小
     * @apiSuccess {Object} data.member
     * @apiSuccess {Number} data.member.enabled_mobile_bind_alert 强制绑定手机号[1:是,0否]
     * @apiSuccess {Number} data.member.enabled_face_verify 强制实名认证[1:是,0否]
     * @apiSuccess {Number} data.socialites.qq QQ登录[1:是,0否]
     * @apiSuccess {Number} data.socialites.wechat_scan 微信扫码登录[1:是,0否]
     * @apiSuccess {Number} data.socialites.wechat_oauth 微信授权登录[1:是,0否]
     * @apiSuccess {Number} data.credit1_reward.register 注册送积分
     * @apiSuccess {Number} data.credit1_reward.watched_vod_course 看完录播课送积分
     * @apiSuccess {Number} data.credit1_reward.watched_video 看完视频
     * @apiSuccess {Number} data.credit1_reward.paid_order 支付订单[按订单金额比率奖励积分]
     * @apiSuccess {Number} data.credit1_reward.invite 邀请用户注册
     * @apiSuccess {String[]} data.enabled_addons 已启用插件
     * @apiSuccess {Object[]} data.links 友情链接
     * @apiSuccess {String} data.links.name 链接名
     * @apiSuccess {String} data.links.url 链接地址
     * @apiSuccess {Object[]} data.sliders PC的幻灯片
     * @apiSuccess {String} data.sliders.thumb 幻灯片地址
     * @apiSuccess {String} data.sliders.url 链接地址
     * @apiSuccess {Object[]} data.navs PC的导航栏
     * @apiSuccess {String} data.navs.name 导航名
     * @apiSuccess {String} data.navs.url 导航地址
     */
    public function config(Addons $addons, ConfigServiceInterface $configService, LinkCache $linkCache, SliderCache $sliderCache, NavCache $navCache)
    {
        // 跑马灯的配置
        $playerConfig = $configService->getPlayer();
        $bulletSecret = $playerConfig['bullet_secret'] ?? [];

        // 已启用的插件
        $enabledAddons = $addons->enabledAddons();

        /**
         * @var \App\Meedu\ServiceV2\Services\ConfigServiceInterface $configServiceV2
         */
        $configServiceV2 = app()->make(\App\Meedu\ServiceV2\Services\ConfigServiceInterface::class);

        $data = [
            // 网站名-推荐前端以后用这个
            'name' => $configService->getName(),
            // 网站logo
            'logo' => $configService->getLogo(),
            // 网站地址
            'url' => trim($configService->getUrl(), '/'),
            'pc_url' => trim($configService->getPcUrl(), '/'),
            'h5_url' => trim($configService->getH5Url(), '/'),
            // ICP备案
            'icp' => $configService->getIcp(),
            'icp_link' => $configService->getIcpLink(),
            // 公安网备案
            'icp2' => $configService->getIcp2(),
            'icp2_link' => $configService->getIcp2Link(),
            // 用户协议URL
            'user_protocol' => route('user.protocol'),
            // 用户隐私协议URL
            'user_private_protocol' => route('user.private_protocol'),
            // VIP协议
            'vip_protocol' => route('user.vip_protocol'),
            // 付费内容购买协议URL
            'paid_content_purchase_protocol' => route('user.paid_content_purchase_protocol'),
            // 关于我们URL
            'aboutus' => route('aboutus'),
            // 课程购买须知
            'course_purchase_notice' => $configService->getCoursePurchaseNotice(),
            // 播放器配置
            'player' => [
                // 播放器封面
                'cover' => $configService->getPlayerCover(),
                // 跑马灯
                'enabled_bullet_secret' => $playerConfig['enabled_bullet_secret'] ?? 0,
                'bullet_secret' => [
                    'size' => $bulletSecret['size'] ?: 14,
                    'color' => $bulletSecret['color'] ?: 'red',
                    'opacity' => $bulletSecret['opacity'] ?: 1,
                    'text' => $bulletSecret['text'] ?: '${mobile}',
                ],
            ],
            'member' => [
                // 强制绑定手机号
                'enabled_mobile_bind_alert' => $configService->getEnabledMobileBindAlert(),
                // 强制实名认证
                'enabled_face_verify' => $configServiceV2->enabledFaceVerify(),
            ],
            // 社交登录
            'socialites' => [
                'qq' => $configService->getSocialiteQQLoginEnabled(),
                'wechat_oauth' => $configService->getSocialiteWechatLoginEnabled(),
            ],
            // 积分奖励
            'credit1_reward' => [
                // 注册
                'register' => $configService->getRegisterSceneCredit1(),
                // 看完录播课
                'watched_vod_course' => $configService->getWatchedCourseSceneCredit1(),
                // 看完视频
                'watched_video' => $configService->getWatchedVideoSceneCredit1(),
                // 已支付订单[抽成]
                'paid_order' => $configService->getPaidOrderSceneCredit1(),
            ],
            // 已用插件
            'enabled_addons' => $enabledAddons,
        ];

        // PC幻灯片
        $data['sliders'] = $sliderCache->get(FrontendConstant::SLIDER_PLATFORM_PC);
        // PC导航栏
        $data['navs'] = $navCache->get(FrontendConstant::NAV_PLATFORM_PC);
        // PC首页友情链接
        $data['links'] = $linkCache->get();

        $data = HookRun::mount(HookConstant::FRONTEND_OTHER_CONTROLLER_CONFIG_RETURN_DATA, $data);

        return $this->data($data);
    }
}
