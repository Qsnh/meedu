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
use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Http\Requests\ApiV2\SmsRequest;
use App\Services\Other\Services\SmsService;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Services\ConfigService;
use App\Services\Other\Interfaces\SmsServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

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
        CacheService $cacheService
    ) {
        $this->smsService = $smsService;
        $this->configService = $configService;
        $this->cacheService = $cacheService;
    }

    /**
     * @OA\Post(
     *     path="/captcha/image",
     *     summary="图形验证码",
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
    public function imageCaptcha()
    {
        $data = Captcha::create('default', true);

        return $this->success($data);
    }

    /**
     * @OA\Post(
     *     path="/captcha/sms",
     *     summary="发送手机验证码",
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="mobile",description="手机号",type="string"),
     *         @OA\Property(property="mobile_code",description="手机验证码",type="string"),
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
     * @param SmsRequest $request
     * @throws \App\Exceptions\ApiV2Exception
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
     */
    public function sentSms(SmsRequest $request)
    {
        $this->checkImageCaptcha();
        ['mobile' => $mobile, 'scene' => $scene] = $request->filldata();
        $code = str_pad(mt_rand(0, 999999), 6, 0, STR_PAD_LEFT);
        $templateIdFuncs = [
            'register' => function () {
                return $this->configService->getRegisterSmsTemplateId();
            },
            'login' => function () {
                return $this->configService->getLoginSmsTemplateId();
            },
            'password_reset' => function () {
                return $this->configService->getPasswordResetSmsTemplateId();
            },
        ];
        $templateId = $templateIdFuncs[$scene]();
        $this->smsService->sendCode($mobile, $code, $templateId);
        $this->cacheService->put(sprintf(ApiV2Constant::MOBILE_OR_PASSWORD_ERROR, $mobile), $code, ApiV2Constant::SMS_CODE_EXPIRE);
        $this->success();
    }
}
