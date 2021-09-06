<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class OtherController extends BaseController
{

    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @api {get} /api/v2/other/config 系统配置
     * @apiGroup 其它
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.webname 网站名
     * @apiSuccess {String} data.icp ICP备案号
     * @apiSuccess {String} data.user_protocol 用户协议URL
     * @apiSuccess {String} data.user_private_protocol 用户隐私协议URL
     * @apiSuccess {String} data.aboutus 关于我们
     * @apiSuccess {String} data.logo LOGO的URL
     * @apiSuccess {Object} data.player 播放器
     * @apiSuccess {String} data.player.cover 播放器封面
     * @apiSuccess {Number} data.player.enabled_bullet_secret 开启跑马灯[1:是,0否]
     * @apiSuccess {Object} data.member
     * @apiSuccess {Number} data.member.enabled_mobile_bind_alert 强制绑定手机号[1:是,0否]
     */
    public function config()
    {
        $plyaerConfig = $this->configService->getPlayer();
        $data = [
            'webname' => $this->configService->getName(),
            'icp' => $this->configService->getIcp(),
            'user_protocol' => route('user.protocol'),
            'user_private_protocol' => route('user.private_protocol'),
            'aboutus' => route('aboutus'),
            'logo' => $this->configService->getLogo(),
            'player' => [
                'cover' => $this->configService->getPlayerCover(),
                'enabled_bullet_secret' => $plyaerConfig['enabled_bullet_secret'] ?? 0,
            ],
            'member' => [
                'enabled_mobile_bind_alert' => $this->configService->getEnabledMobileBindAlert(),
            ]
        ];
        return $this->data($data);
    }
}
