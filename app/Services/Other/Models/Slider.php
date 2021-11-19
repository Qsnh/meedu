<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'sliders';

    protected $fillable = [
        'thumb', 'sort', 'url', 'platform',
    ];
}
