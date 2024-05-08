<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{

    protected $table = 'app_config';

    protected $fillable = [
        'group', 'name', 'field_type', 'sort', 'default_value', 'key', 'value', 'is_private',
        'option_value', 'help', 'is_show',
    ];

}
