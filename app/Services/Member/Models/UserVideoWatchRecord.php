<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserVideoWatchRecord extends Model
{
    use SoftDeletes;

    protected $table = 'user_video_watch_records';

    protected $fillable = [
        'user_id', 'course_id', 'video_id', 'watch_seconds', 'watched_at',
    ];
}
