<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Hooks;

interface HookRuntimeInterface
{
    public function handle(HookParams $params, \Closure $closure);
}
