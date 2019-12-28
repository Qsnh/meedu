<?php


namespace App\Http\Controllers\Api\V2;

use Mews\Captcha\Captcha;

class CaptchaController extends BaseController
{

    public function imageCaptcha()
    {
        $data = Captcha::create('default', true);
        return $this->success($data);
    }

}