<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministratorMenu extends Model
{
    protected $table = 'administrator_menus';

    protected $fillable = [
        'parent_id', 'name', 'url', 'icon', 'permission', 'sort',
        'is_super',
    ];

    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }
}
