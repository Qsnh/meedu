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

use Mews\Captcha\Captcha;
use App\Constant\CacheConstant;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ApiV2\SmsRequest;
use App\Services\Other\Services\SmsService;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Services\ConfigService;
use App\Services\Other\Interfaces\SmsServiceInterface;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

/**
 * Class CaptchaController
 * @package App\Http\Controllers\Api\V2
 */
class CaptchaController extends BaseController
{

    /**
     * @var SmsService
     */
    protected $smsService;
    /**
     * @var ConfigService
     */
    protected $configService;
    /**
     * @var CacheService
     */
    protected $cacheService;

    public function __construct(
        SmsServiceInterface $smsService,
        ConfigServiceInterface $configService,
        CacheServiceInterface $cacheService
    ) {
        $this->smsService = $smsService;
        $this->configService = $configService;
        $this->cacheService = $cacheService;
    }

    /**
     * @OA\Post(
     *     path="/captcha/image",
     *     summary="图形验证码",
     *     tags={"其它"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="key",type="string",description="key"),
     *                 @OA\Property(property="img",type="string",description="图片内容"),
     *             ),
     *         )
     *     )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function imageCaptcha(Captcha $captcha)
    {
        $data = $captcha->create('default', true);

        return $this->data($data);
    }

    /**
     * @OA\Post(
     *     path="/captcha/sms",
     *     summary="发送手机验证码",
     *     tags={"其它"},
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="mobile",description="手机号",type="string"),
     *         @OA\Property(property="image_captcha",description="图形验证码",type="string"),
     *         @OA\Property(property="image_key",description="图形验证码key",type="string"),
     *         @OA\Property(property="scene",description="scene[login:登录,register:注册,password_reset:密码重置]",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description=""),
     *         )
     *     )
     * )
     *
     * @param SmsRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiV2Exception
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
     */
    public function sentSms(SmsRequest $request)
    {
        $this->checkImageCaptcha();
        ['mobile' => $mobile, 'scene' => $scene] = $request->filldata();
        $code = str_pad(random_int(0, 999999), 6, 0, STR_PAD_LEFT);

        if (!is_dev()) {
            // 正式环境才发送验证码
            $this->smsService->sendCode($mobile, $code, $scene);
        } else {
            // 测试环境将验证码记录在log
            Log::info(__METHOD__, compact('code'));
        }

        $this->cacheService->put(
            get_cache_key(CacheConstant::MOBILE_CODE['name'], $mobile),
            $code,
            CacheConstant::MOBILE_CODE['expire']
        );

        return $this->success();
    }
}
