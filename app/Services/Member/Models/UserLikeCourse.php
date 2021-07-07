<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
