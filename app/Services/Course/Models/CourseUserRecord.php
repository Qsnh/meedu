<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
