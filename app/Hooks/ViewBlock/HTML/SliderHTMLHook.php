<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Hooks\ViewBlock\HTML;

use App\Meedu\Hooks\HookParams;
use App\Meedu\ViewBlock\Constant;
use App\Meedu\Hooks\HookRuntimeInterface;

class SliderHTMLHook implements HookRuntimeInterface
{
    public function handle(HookParams $params, \Closure $closure)
    {
        $block = $params->getValue('block');

        if (!in_array($block['sign'], [Constant::H5_BLOCK_SIGN_SLIDER])) {
            return $closure($params);
        }

        $html = app('Illuminate\View\Factory')->file(resource_path('views/h5/view-block/slider.blade.php'), ['block' => $block])->render();
        $params->setResponse($html);

        return $closure($params);
    }
}
