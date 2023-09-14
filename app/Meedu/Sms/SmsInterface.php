<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Sms;

interface SmsInterface
{
    public function sendCode(string $mobile, $code, $template);
}
