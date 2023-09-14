<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceProxy\Cache;

class CacheInfo
{
    protected $name;

    protected $expire;

    /**
     * CacheInfo constructor.
     *
     * @param $name
     * @param $expire
     */
    public function __construct($name, $expire)
    {
        $this->name = $name;
        $this->expire = $expire;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $expire
     */
    public function setExpire($expire): void
    {
        $this->expire = $expire;
    }
}
