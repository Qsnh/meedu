<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Models;

use App\Constant\TableConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLikeCourse extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = TableConstant::TABLE_USER_LIKE_COURSES;

    protected $fillable = [
        'user_id', 'course_id',
    ];
}
