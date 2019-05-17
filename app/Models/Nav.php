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

/**
 * App\Models\Nav.
 *
 * @property int                             $id
 * @property int                             $sort
 * @property string                          $name       链接名
 * @property string                          $url        链接地址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nav newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nav newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nav query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nav whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nav whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nav whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nav whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nav whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Nav whereUrl($value)
 * @mixin \Eloquent
 */
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
            }
        );
    }
}
