<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
