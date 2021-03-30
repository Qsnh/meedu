<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseUserRecord extends Model
{
    use SoftDeletes;

    protected $table = 'course_user_records';

    protected $fillable = [
        'course_id', 'user_id', 'is_watched', 'watched_at', 'progress',
    ];
}
