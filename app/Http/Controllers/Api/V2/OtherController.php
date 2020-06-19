<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V2;

use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

/**
 * @OpenApi\Annotations\Schemas(
 *     @OA\Schema(
 *         schema="Config",
 *         type="object",
 *         title="系统配置",
 *         @OA\Property(property="webname",type="string",description="网站名"),
 *         @OA\Property(property="icp",type="string",description="备案信息"),
 *         @OA\Property(property="user_protocol",type="string",description="用户协议url"),
 *         @OA\Property(property="user_private_protocol",type="string",description="隐私政策协议url"),
 *         @OA\Property(property="aboutus",type="integer",description="关于我们url"),
 *         @OA\Property(property="logo",type="object",description="logo",@OA\Property(
 *             @OA\Property(property="logo",type="string",description="默认logo"),
 *             @OA\Property(property="white_logo",type="string",description="白色logo"),
 *         )),
 *         @OA\Property(property="player",type="object",description="播放器",@OA\Property(
 *             @OA\Property(property="cover",type="string",description="封面"),
 *             @OA\Property(property="enabled_bullet_secret",type="integer",description="是否开启跑马灯"),
 *             @OA\Property(property="enabled_aliyun_private",type="integer",description="阿里云私密播放"),
 *         )),
 *         @OA\Property(property="member",type="object",description="会员配置",@OA\Property(
 *             @OA\Property(property="enabled_mobile_bind_alert",type="integer",description="强制绑定手机号，1是"),
 *         )),
 *     ),
 * )
 */
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
     * @OA\Get(
     *     path="/other/config",
     *     summary="系统配置",
     *     tags={"其它"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",ref="#/components/schemas/Config"),
     *         )
     *     )
     * )
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
                'enabled_aliyun_private' => $plyaerConfig['enabled_aliyun_private'] ?? 0,
            ],
            'member' => [
                'enabled_mobile_bind_alert' => $this->configService->getEnabledMobileBindAlert(),
            ]
        ];
        return $this->data($data);
    }
}
