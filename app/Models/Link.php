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

class Link extends Model
{
    protected $table = 'links';

    protected $fillable = ['sort', 'name', 'url'];

    protected $appends = [
        'edit_url', 'destroy_url',
    ];

    public function getEditUrlAttribute()
    {
        return route('backend.link.edit', $this);
    }

    public function getDestroyUrlAttribute()
    {
        return route('backend.link.destroy', $this);
    }

    /**
     * 缓存.
     *
     * @return mixed
     */
    public static function linksCache()
    {
        return self::orderBy('sort')->get();

        return Cache::remember('links', 60, function () {
            return self::orderBy('sort')->get();
        });
    }
}
