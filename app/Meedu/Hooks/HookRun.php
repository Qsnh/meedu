<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Hooks;

use Illuminate\Pipeline\Pipeline;

class HookRun
{
    /**
     * 运行得到response
     * @param $hook
     * @param HookParams $hookParams
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function run($hook, HookParams $hookParams)
    {
        $hooks = HookContainer::getInstance()->get($hook);
        if ($hooks) {
            return app()->make(Pipeline::class)
                ->send($hookParams)
                ->through($hooks)
                ->then(function ($response) {
                    /**
                     * @var HookParams $response
                     */
                    return $response->getResponse();
                });
        }
    }

    /**
     * 不关注response,仅关注走完pipeline之后的传入的参数变化
     * @param $hook
     * @param HookParams $hookParams
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function pack($hook, HookParams $hookParams)
    {
        $hooks = HookContainer::getInstance()->get($hook);
        if ($hooks) {
            return app()->make(Pipeline::class)
                ->send($hookParams)
                ->through($hooks)
                ->then(function ($response) {
                    /**
                     * @var HookParams $response
                     */
                    return $response->getParams();
                });
        }
    }
}
