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
 *         @OA\Property(property="user_protocol",type="string",description="用户协议url"),
 *         @OA\Property(property="aboutus",type="integer",description="关于我们url"),
 *         @OA\Property(property="logo",type="object",description="logo",@OA\Property(
 *             @OA\Property(property="logo",type="string",description="默认logo"),
 *             @OA\Property(property="white_logo",type="string",description="白色logo"),
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
     *
     * @return void
     */
    public function config()
    {
        $data = [
            'webname' => $this->configService->getName(),
            'user_protocol' => route('user.protocol'),
            'aboutus' => route('aboutus'),
            'logo' => $this->configService->getLogo(),
        ];
        return $this->data($data);
    }
}
