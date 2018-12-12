<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $table = 'navs';

    protected $fillable = [
        'sort', 'name', 'url',
    ];

    /**
     * 获取所有数据.
     *
     * @return mixed
     */
    public function allCache()
    {
        if (config('meedu.system.cache.status', -1) != 1) {
            return $this->orderBy('sort')->get();
        }
        $that = $this;

        return Cache::remember(
            'navs',
            config('meedu.system.cache.expire', 60),
            function () use ($that) {
                return $this->orderBy('sort')->get();
            });
    }
}
