<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Mews\Captcha\Captcha;

class CaptchaController extends BaseController
{
    public function image(Captcha $captcha)
    {
        $data = $captcha->create('default', true);

        return $this->successData($data);
    }
}
