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

use EasyWeChat\Factory;
use Illuminate\Http\Request;
use App\Constant\CacheConstant;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class WechatMiniController extends BaseController
{
    protected $app;

    /**
     * @var ConfigService
     */
    protected $configService;

    /**
     * @var CacheService
     */
    protected $cacheService;

    /**
     * WechatMiniController constructor.
     * @param ConfigServiceInterface $configService
     * @param CacheServiceInterface $cacheService
     */
    public function __construct(
        ConfigServiceInterface $configService,
        CacheServiceInterface $cacheService
    ) {
        $this->configService = $configService;
        $this->cacheService = $cacheService;

        $config = [
            'log' => [
                'level' => 'debug',
                'file' => storage_path('logs/wechat-mini-' . date('Y-m-d') . '.log'),
            ],
        ];
        $this->app = Factory::miniProgram(array_merge($config, $this->configService->getTencentWechatMiniConfig()));
    }

    /**
     * @OA\Post(
     *     path="/wechat/mini/login",
     *     summary="微信小程序静默登录",
     *     tags={"Auth"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="code",description="code",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="openid",type="string",description="openid"),
     *                 @OA\Property(property="session_key",type="string",description="session_key"),
     *             ),
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function login(Request $request)
    {
        $code = $request->input('code');
        $info = $this->app->auth->session($code);
        if (!isset($info['openid'])) {
            return $this->error(__('error'));
        }
        $openid = $info['openid'];

        // session_key存入缓存
        $this->cacheService->put(
            get_cache_key(CacheConstant::WECHAT_MINI_SESSION_KEY['name'], $openid),
            $info['session_key'],
            CacheConstant::WECHAT_MINI_SESSION_KEY['expire']
        );

        return $this->data([
            'openid' => $openid,
        ]);
    }
}
