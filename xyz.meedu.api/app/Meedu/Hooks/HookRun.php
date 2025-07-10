<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Hooks;

use Illuminate\Pipeline\Pipeline;

class HookRun
{

    public static function mount(string $hookName, $data, $defaultValue = null)
    {
        return self::run($hookName, new HookParams($data), $defaultValue);
    }

    public static function subscribe(string $hookName, $data = [])
    {
        return self::pack($hookName, new HookParams($data));
    }

    public static function run($hook, HookParams $params, $defaultValue = null)
    {
        $hooks = HookContainer::getInstance()->get($hook);
        if (!$hooks) {
            // 如果指定默认返回值的话则返回默认值
            if (!is_null($defaultValue)) {
                return $defaultValue;
            }
            // 如果没有指定默认值则返回原样传递的参数
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
