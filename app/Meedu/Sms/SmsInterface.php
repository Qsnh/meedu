<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Meedu\Sms;

interface SmsInterface
{
    public function sendCode(string $mobile, $code, $template);
}
