<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\ServiceProxy\Lock;

class LockInfo
{
    protected $name;

    protected $seconds;

    /**
     * LockInfo constructor.
     *
     * @param $name
     * @param $seconds
     */
    public function __construct($name, $seconds)
    {
        $this->name = $name;
        $this->seconds = $seconds;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * @param mixed $seconds
     */
    public function setSeconds($seconds): void
    {
        $this->seconds = $seconds;
    }
}
