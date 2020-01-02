<?php


namespace Tests\Feature\Api\V2;


class CaptchaImageTest extends Base
{

    public function test_captchaImage()
    {
        $this->get('/api/v2/captcha/image')
            ->seeStatusCode(200);
    }

}