<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    protected $table = 'user_course';

    protected $fillable = [
        'course_id', 'user_id', 'charge', 'created_at',
    ];

    public $timestamps = false;
}
