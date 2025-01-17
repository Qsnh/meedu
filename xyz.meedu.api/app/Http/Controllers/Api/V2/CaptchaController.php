<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Constant\CacheConstant;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ApiV2\SmsRequest;
use App\Services\Base\Services\CacheService;
use App\Services\Other\Interfaces\SmsServiceInterface;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class CaptchaController extends BaseController
{
    protected $smsService;

    protected $configService;
    /**
     * @var CacheService
     */
    protected $cacheService;

    public function __construct(
        SmsServiceInterface    $smsService,
        ConfigServiceInterface $configService,
        CacheServiceInterface  $cacheService
    ) {
        $this->smsService = $smsService;
        $this->configService = $configService;
        $this->cacheService = $cacheService;
    }

    /**
     * @api {get} /api/v2/captcha/image [V2]图形验证码
     * @apiGroup 系统模块
     * @apiName CaptchaImage
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.key 随机键值
     * @apiSuccess {String} data.img 图片base64码
     */
    public function imageCaptcha()
    {
        $captcha = app()->make('captcha');
        $data = $captcha->create('default', true);

        return $this->data($data);
    }

    /**
     * @api {post} /api/v2/captcha/sms [V2]短信发送
     * @apiGroup 系统模块
     * @apiName CaptchaSMS
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} image_captcha 图形验证码
     * @apiParam {String} image_key 图形验证码随机值
     * @apiParam {String=login,register,password_reset,mobile_bind} scene scene
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function sentSms(SmsRequest $request)
    {
        if (captcha_image_check() === false) {
            return $this->error(__('图形验证码错误'));
        }

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
