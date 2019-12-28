<?php


namespace App\Http\Controllers\Api\V2;


use App\Constant\ApiV2Constant;
use App\Exceptions\ApiV2Exception;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;

/**
 * @OpenApi\Annotations\Swagger(
 *     host="",
 *     basePath="/api/v2",
 *     @OA\Info(
 *         title="MeEdu API V2",
 *         version="2.0"
 *     )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="https",
 *     type="apiKey",
 *     in="header",
 *     description="Authorization Bearer token",
 *     name="Authorization"
 * )
 *
 * Class BaseController
 * @package App\Http\Controllers\Api\V2
 */
class BaseController
{
    use ResponseTrait;

    protected $guard = 'apiv2';

    /**
     * @throws ApiV2Exception
     */
    protected function checkImageCaptcha()
    {
        $imageKey = request()->input('image_key');
        if (!$imageKey) {
            throw new ApiV2Exception(ApiV2Constant::PLEASE_INPUT_IMAGE_CAPTCHA);
        }
        $imageCaptcha = request()->input('image_captcha', '');
        if (!captcha_api_check($imageCaptcha, $imageKey)) {
            throw new ApiV2Exception(ApiV2Constant::IMAGE_CAPTCHA_ERROR);
        }
    }

}