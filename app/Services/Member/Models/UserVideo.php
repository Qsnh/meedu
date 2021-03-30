<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;

class UserVideo extends Model
{
    protected $table = 'user_video';

    protected $fillable = [
        'user_id', 'video_id', 'charge', 'created_at',
    ];

    public $timestamps = false;
}
