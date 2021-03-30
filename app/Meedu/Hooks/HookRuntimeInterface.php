<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Meedu\Hooks;

interface HookRuntimeInterface
{
    public function handle(HookParams $params, \Closure $closure);
}
