<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLikeCourse extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'user_like_courses';

    protected $fillable = [
        'user_id', 'course_id',
    ];
}
