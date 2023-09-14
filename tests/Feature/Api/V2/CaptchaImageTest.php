<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V2;

class CaptchaImageTest extends Base
{
    public function test_captchaImage()
    {
        $this->get('/api/v2/captcha/image')
            ->seeStatusCode(200);
    }
}
