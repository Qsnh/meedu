<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
     * @api {get} /api/v2/captcha/image 图形验证码
     * @apiGroup 其它
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.key 随机键值
     * @apiSuccess {String} data.img 图片base64码
     */
    public function imageCaptcha(Captcha $captcha)
    {
        $data = $captcha->create('default', true);

        return $this->data($data);
    }

    /**
     * @api {post} /api/v2/captcha/sms 发送短信
     * @apiGroup 其它
     * @apiVersion v2.0.0
     *
     * @apiParam {String} mobile 手机号
     * @apiParam {String} image_captcha 图形验证码
     * @apiParam {String} image_key 图形验证码随机值
     * @apiParam {String=login,register,password_reset} scene 场景[login:登录,register:注册,password_reset:密码重置]
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
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
