<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Hooks;

use Illuminate\Pipeline\Pipeline;

class HookRun
{
    /**
     * 运行得到response
     * @param $hook
     * @param HookParams $params
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function run($hook, HookParams $params)
    {
        $hooks = HookContainer::getInstance()->get($hook);
        if (!$hooks) {
            return $params->getParams();
        }

        return app()->make(Pipeline::class)
            ->send($params)
            ->through($hooks)
            ->then(function ($params) {
                /**
                 * @var HookParams $params
                 */
                return $params->getResponse();
            });
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
