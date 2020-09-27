<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Cache\Inc;

abstract class IncItem
{
    protected $inc = 1;
    protected $limit = 100;

    /**
     * @return int
     */
    public function getInc(): int
    {
        return $this->inc;
    }

    /**
     * @param int $inc
     */
    public function setInc(int $inc): void
    {
        $this->inc = $inc;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }


    public function getKey(): string
    {
    }

    public function save(): void
    {
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
