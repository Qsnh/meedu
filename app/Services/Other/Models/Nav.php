<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Other\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $table = 'navs';

    protected $fillable = [
        'sort', 'name', 'url', 'active_routes', 'platform', 'parent_id',
    ];

    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }
}
