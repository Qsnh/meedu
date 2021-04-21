<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLikeCourse extends Model
{
    use SoftDeletes;

    protected $table = 'user_like_courses';

    protected $fillable = [
        'user_id', 'course_id',
    ];
}
