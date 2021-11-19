<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserVideo extends Model
{
    use HasFactory;
    protected $table = 'user_video';

    protected $fillable = [
        'user_id', 'video_id', 'charge', 'created_at',
    ];

    public $timestamps = false;
}
