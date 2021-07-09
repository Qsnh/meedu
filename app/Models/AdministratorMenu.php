<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
