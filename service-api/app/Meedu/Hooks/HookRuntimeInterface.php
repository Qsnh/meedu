<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Hooks;

interface HookRuntimeInterface
{
    public function handle(HookParams $params, \Closure $closure);
}
