<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Models;

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
