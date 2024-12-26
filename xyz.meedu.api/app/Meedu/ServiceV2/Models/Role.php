<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{

    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name', 'charge', 'expire_days', 'weight', 'description',
        'is_show',
    ];

}
