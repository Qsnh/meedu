<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\ServiceProxy;

use Illuminate\Cache\RateLimiter;
use App\Exceptions\SystemException;
use App\Meedu\ServiceProxy\Lock\LockInfo;
use App\Meedu\ServiceProxy\Cache\CacheInfo;
use App\Services\Base\Services\CacheService;
use App\Services\Base\Services\ConfigService;
use App\Meedu\ServiceProxy\Limiter\LimiterInfo;

class ServiceProxy
{
    protected $service;

    /**
     * @var CacheService
     */
    protected $cacheService;

    /**
     * @var ConfigService
     */
    protected $configService;

    /**
     * 缓存注册表.
     *
     * @var array
     */
    protected $cache = [];

    /**
     * 限流注册表.
     *
     * @var array
     */
    protected $limit = [];

    /**
     * 锁注册表.
     *
     * @var array
     */
    protected $lock = [];

    public function __construct($service)
    {
        $this->service = $service;
        $this->cacheService = app()->make(CacheService::class);
        $this->configService = app()->make(ConfigService::class);
    }

    /**
     * @param string $methodName
     * @param \Closure $cacheHandler
     *
     * @return $this
     */
    public function setCache(string $methodName, \Closure $cacheHandler)
    {
        $this->cache[$methodName] = $cacheHandler;

        return $this;
    }

    /**
     * @param string $methodName
     *
     * @return $this
     */
    public function setLock(string $methodName)
    {
        $this->lock[$methodName] = 1;

        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed|void
     *
     * @throws SystemException
     */
    public function __call($name, $arguments)
    {
        // 锁控制
        if (isset($this->lock[$name])) {
            return $this->lockHandlerBefore($name, $arguments);
        }
        // 限流
        $this->limitHandler($name, $arguments);
        // 缓存
        return $this->cacheHandler($name, $arguments);
    }

    /**
     * @param $name
     * @param $args
     *
     * @return mixed
     */
    public function cacheHandler($name, $args)
    {
        if (!isset($this->cache[$name]) || !$this->configService->getCacheStatus()) {
            // 未开启缓存 || 没开启缓存
            return $this->run([$this->service, $name], $args);
        }
        /**
         * @var $cacheInfo CacheInfo
         */
        $cacheInfo = $this->run($this->cache[$name], $args);
        if (!$cacheInfo) {
            return $this->run([$this->service, $name], $args);
        }
        $cacheData = $this->cacheService->get($cacheInfo->getName());
        if ($cacheData) {
            return $cacheData;
        }

        $response = $this->run([$this->service, $name], $args);

        $this->cacheService->put($cacheInfo->getName(), $response, $cacheInfo->getExpire());

        return $response;
    }

    /**
     * @param $name
     * @param $args
     *
     * @return mixed|void
     *
     * @throws SystemException
     */
    protected function lockHandlerBefore($name, $args)
    {
        /**
         * @var LockInfo
         */
        $lockInfo = call_user_func_array($this->lock[$name], $args);
        $lock = $this->cacheService->lock($lockInfo->getName(), $lockInfo->getSeconds());
        if (!$lock->get()) {
            // 无法获取锁
            throw new SystemException(__('error'));
        }
        $response = $this->run([$this->service, $name], $args);
        $lock->release();

        return $response;
    }

    /**
     * @param $name
     * @param $args
     * @throws SystemException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function limitHandler($name, $args)
    {
        if (!isset($this->limit[$name])) {
            return;
        }
        /**
         * @var $limiterInfo LimiterInfo
         */
        $limiterInfo = call_user_func_array($this->limit[$name], $args);
        /**
         * @var $rateLimiter RateLimiter
         */
        $rateLimiter = app()->make(RateLimiter::class);
        if ($rateLimiter->tooManyAttempts($limiterInfo->getName(), $limiterInfo->getMaxTimes())) {
            throw new SystemException(__('error'));
        }
        $rateLimiter->hit($limiterInfo->getName(), $limiterInfo->getMinutes());
    }

    /**
     * @param $name
     * @param $args
     *
     * @return mixed
     */
    protected function run($name, $args)
    {
        return $args ? call_user_func_array($name, $args) : call_user_func($name);
    }
}
