<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $table = 'navs';

    protected $fillable = [
        'sort', 'name', 'url', 'active_routes', 'platform', 'parent_id',
        'blank',
    ];

    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }
}
